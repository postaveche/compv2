<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TranslateSettings;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function translateBatch(Request $request)
    {
        $settings = TranslateSettings::get();
        if (!$settings->active || !$settings->deepl_api_key) {
            return response()->json(['error' => 'DeepL API nu este configurat'], 400);
        }

        $texts = $request->input('texts', []);
        $from = strtoupper($request->input('from', 'ro'));
        $to = strtoupper($request->input('to', 'ru'));

        $results = [];
        foreach ($texts as $key => $text) {
            if (!empty($text)) {
                $results[$key] = $this->deeplTranslate($text, $from, $to, $settings->deepl_api_key);
            } else {
                $results[$key] = '';
            }
        }

        return response()->json(['translated' => $results]);
    }

    private function deeplTranslate($text, $from, $to, $apiKey)
    {
        $isFree = str_contains($apiKey, ':fx');
        $url = $isFree
            ? 'https://api-free.deepl.com/v2/translate'
            : 'https://api.deepl.com/v2/translate';

        $postData = http_build_query([
            'text' => $text,
            'target_lang' => $to,
        ]);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: DeepL-Auth-Key ' . $apiKey,
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if (isset($result['translations'][0]['text'])) {
                return $result['translations'][0]['text'];
            }

            \Log::error('DeepL error: ' . $response);
        } catch (\Exception $e) {
            \Log::error('DeepL exception: ' . $e->getMessage());
            return $text;
        }

        return $text;
    }

    // Setari
    public function settings()
    {
        $settings = TranslateSettings::get();
        return view('admin.settings.translate', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settings = TranslateSettings::get();
        $settings->update([
            'deepl_api_key' => $request->deepl_api_key,
            'active' => $request->has('active') ? 1 : 0,
        ]);
        return redirect()->route('admin.translate.settings')->with('success', 'Setari salvate!');
    }

    public function test()
    {
        $settings = TranslateSettings::get();
        if (!$settings->active || !$settings->deepl_api_key) {
            return redirect()->route('admin.translate.settings')->with('danger', 'Configureaza cheia API!');
        }
        $result = $this->deeplTranslate('Bună ziua, aceasta este o traducere de test.', 'RO', 'RU', $settings->deepl_api_key);
        return redirect()->route('admin.translate.settings')->with('success', 'Test: ' . $result);
    }
}
