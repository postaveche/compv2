<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use RuntimeException;
use XMLWriter;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--base-url= : URL-ul public, de exemplu https://comp.md}';
    protected $description = 'Generează sitemap-urile XML pentru toate paginile publice RO și RU.';

    private const LANGUAGES = ['ro', 'ru'];
    private const CHUNK_SIZE = 20000;
    private const SITEMAP_NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';
    private const XHTML_NS = 'http://www.w3.org/1999/xhtml';

    private $baseUrl;
    private $generatedFiles = [];

    public function handle()
    {
        $this->baseUrl = rtrim($this->option('base-url') ?: config('app.url'), '/');

        if (! filter_var($this->baseUrl, FILTER_VALIDATE_URL)
            || ! in_array(parse_url($this->baseUrl, PHP_URL_SCHEME), ['http', 'https'], true)) {
            $this->error('APP_URL sau --base-url trebuie să fie un URL HTTP/HTTPS valid.');
            return 1;
        }

        $this->writeStaticSitemap();
        $this->writeDatabaseSitemaps('category', 'sitemap-categories', 'category');
        $this->writeDatabaseSitemaps('product', 'sitemap-products', 'product');
        $this->writeSitemapIndex();
        $this->removeObsoleteParts();

        $this->info('Sitemap generat: '.count($this->generatedFiles).' fișiere pentru '.$this->baseUrl);
        return 0;
    }

    private function writeStaticSitemap()
    {
        $paths = $this->discoverStaticPaths();

        foreach (array_keys(trans('laptop.services', [], 'ro')) as $slug) {
            $paths[] = 'reparatii_laptop_notebook/'.$slug;
        }

        foreach (array_keys(trans('computer.services', [], 'ro')) as $slug) {
            $paths[] = 'reparatie/'.$slug;
        }

        foreach (array_keys(trans('tv.services', [], 'ro')) as $slug) {
            $paths[] = 'reparatii_televizoare/'.$slug;
        }

        foreach (array_keys(trans('console.services', [], 'ro')) as $slug) {
            $paths[] = 'reparatii_console_gaming/'.$slug;
        }

        $paths = array_values(array_unique($paths));
        sort($paths);

        $lastModified = $this->sourceLastModified();
        $this->writeUrlSet('sitemap-pages.xml', function (XMLWriter $xml) use ($paths, $lastModified) {
            foreach ($paths as $path) {
                foreach (self::LANGUAGES as $locale) {
                    $this->writeLocalizedUrl($xml, $locale, $path, $lastModified);
                }
            }
        });
    }

    private function discoverStaticPaths()
    {
        $excludedRouteNames = [
            'locale.all_category', // redirect, nu este o pagină canonică
            'locale.search',       // pagină cu rezultate variabile
            'locale.get_curs',     // endpoint tehnic
            'locale.get_b2b',      // endpoint tehnic
        ];

        return collect(Route::getRoutes()->getRoutes())
            ->filter(function ($route) use ($excludedRouteNames) {
                $name = $route->getName();
                $uri = $route->uri();

                return $name
                    && strpos($name, 'locale.') === 0
                    && in_array('GET', $route->methods(), true)
                    && strpos($uri, '{locale}') !== false
                    && preg_match_all('/\{[^}]+\}/', $uri) === 1
                    && ! in_array($name, $excludedRouteNames, true);
            })
            ->map(function ($route) {
                $path = preg_replace('#^\{locale\}/?#', '', $route->uri());
                return trim($path, '/');
            })
            ->values()
            ->all();
    }

    private function writeDatabaseSitemaps($table, $filePrefix, $pathPrefix)
    {
        $lastId = 0;
        $part = 1;

        do {
            $records = DB::table($table)->select(['id', 'slug', 'updated_at'])
                ->where('active', 1)->where('id', '>', $lastId)
                ->orderBy('id')->limit(self::CHUNK_SIZE)->get();

            if ($records->isEmpty()) {
                break;
            }

            $this->writeUrlSet($filePrefix.'-'.$part.'.xml', function (XMLWriter $xml) use ($records, $pathPrefix) {
                foreach ($records as $record) {
                    $path = $pathPrefix.'/'.ltrim($record->slug, '/');
                    foreach (self::LANGUAGES as $locale) {
                        $this->writeLocalizedUrl($xml, $locale, $path, $this->formatLastModified($record->updated_at));
                    }
                }
            });

            $lastId = $records->last()->id;
            $part++;
        } while ($records->count() === self::CHUNK_SIZE);
    }

    private function writeLocalizedUrl(XMLWriter $xml, $locale, $path, $lastModified)
    {
        $xml->startElement('url');
        $xml->writeElement('loc', $this->localizedUrl($locale, $path));
        $xml->writeElement('lastmod', $lastModified);

        foreach (self::LANGUAGES as $alternateLocale) {
            $this->writeAlternate($xml, $alternateLocale, $this->localizedUrl($alternateLocale, $path));
        }
        $this->writeAlternate($xml, 'x-default', $this->localizedUrl('ro', $path));
        $xml->endElement();
    }

    private function writeAlternate(XMLWriter $xml, $language, $url)
    {
        $xml->startElementNS('xhtml', 'link', self::XHTML_NS);
        $xml->writeAttribute('rel', 'alternate');
        $xml->writeAttribute('hreflang', $language);
        $xml->writeAttribute('href', $url);
        $xml->endElement();
    }

    private function writeUrlSet($fileName, callable $callback)
    {
        $this->writeXmlFile($fileName, function (XMLWriter $xml) use ($callback) {
            $xml->startElement('urlset');
            $xml->writeAttribute('xmlns', self::SITEMAP_NS);
            $xml->writeAttribute('xmlns:xhtml', self::XHTML_NS);
            $callback($xml);
            $xml->endElement();
        });
    }

    private function writeSitemapIndex()
    {
        $parts = $this->generatedFiles;
        $generatedAt = now()->utc()->toAtomString();

        $this->writeXmlFile('sitemap.xml', function (XMLWriter $xml) use ($parts, $generatedAt) {
            $xml->startElement('sitemapindex');
            $xml->writeAttribute('xmlns', self::SITEMAP_NS);
            foreach ($parts as $fileName) {
                $xml->startElement('sitemap');
                $xml->writeElement('loc', $this->baseUrl.'/'.$fileName);
                $xml->writeElement('lastmod', $generatedAt);
                $xml->endElement();
            }
            $xml->endElement();
        }, false);
    }

    private function writeXmlFile($fileName, callable $callback, $register = true)
    {
        $temporaryPath = storage_path('app/'.$fileName.'.tmp');
        $destinationPath = public_path($fileName);
        File::ensureDirectoryExists(dirname($temporaryPath));

        $xml = new XMLWriter();
        if (! $xml->openURI($temporaryPath)) {
            throw new RuntimeException('Nu poate fi creat '.$temporaryPath);
        }
        $xml->startDocument('1.0', 'UTF-8');
        $xml->setIndent(true);
        $callback($xml);
        $xml->endDocument();
        $xml->flush();

        File::replace($destinationPath, File::get($temporaryPath));
        File::delete($temporaryPath);

        if ($register) {
            $this->generatedFiles[] = $fileName;
        }
    }

    private function removeObsoleteParts()
    {
        foreach (File::glob(public_path('sitemap-*.xml')) as $path) {
            if (! in_array(basename($path), $this->generatedFiles, true)) {
                File::delete($path);
            }
        }
    }

    private function localizedUrl($locale, $path)
    {
        return $this->baseUrl.'/'.$locale.($path !== '' ? '/'.ltrim($path, '/') : '');
    }

    private function sourceLastModified()
    {
        $files = [base_path('routes/web.php'), resource_path('views/pages/reparatie.blade.php'),
            resource_path('views/pages/reparatie_service.blade.php'), resource_path('lang/ro/computer.php'),
            resource_path('lang/ru/computer.php'), resource_path('views/pages/reparatie_laptop.blade.php'),
            resource_path('views/pages/reparatie_laptop_service.blade.php'), resource_path('lang/ro/laptop.php'),
            resource_path('lang/ru/laptop.php'), resource_path('views/pages/reparatie_tv.blade.php'),
            resource_path('views/pages/reparatie_tv_service.blade.php'), resource_path('lang/ro/tv.php'),
            resource_path('lang/ru/tv.php'), resource_path('views/pages/reparatie_console.blade.php'),
            resource_path('views/pages/reparatie_console_service.blade.php'), resource_path('lang/ro/console.php'),
            resource_path('lang/ru/console.php')];

        return Carbon::createFromTimestamp(max(array_map('filemtime', $files)))->utc()->toAtomString();
    }

    private function formatLastModified($value)
    {
        return $value ? Carbon::parse($value)->utc()->toAtomString() : now()->utc()->toAtomString();
    }
}
