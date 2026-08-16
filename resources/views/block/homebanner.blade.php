<div class="banner_grup justify-content-center flex">
    @foreach($banners as $banner)
        @php
            $locale = in_array(app()->getLocale(), ['ro', 'ru'], true) ? app()->getLocale() : 'ro';
            $originalPath = 'public/banners/'.$banner->image;
            $optimizedPath = $originalPath.'@300';
            $imagePath = config('app.env') === 'production' && Storage::exists($optimizedPath)
                ? $optimizedPath
                : $originalPath;
            $bannerUrl = url($locale.'/'.ltrim($banner->link, '/'));
        @endphp
        <div class="tns-item">
            <div class="rounded" style="background-image:url('{{ Storage::url($imagePath) }}');background-size:cover;background-position:center;box-shadow:#536473 0 220px 170px -60px inset;color:#fff">
                <div class="item_grup">
                    <a href="{{ $bannerUrl }}">
                        <div class="item_bann banner_nume">{{ $locale === 'ru' ? $banner->name_ru : $banner->name }}</div>
                        <div class="item_bann small">{{ $locale === 'ru' ? $banner->desc_ru : $banner->desc }}</div>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
