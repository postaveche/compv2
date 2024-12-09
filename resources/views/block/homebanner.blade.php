<div class="banner_grup justify-content-center flex ">
    @foreach($banners as $banner)
<div class="tns-item">
    <div class="rounded" style="background-image:url(/storage/banners/{{$banner['image']}}{{(config('app.env') === 'production' ? '@300' : '')}});background-size: cover;box-shadow:#536473 0 220px 170px -60px inset;color:#fff">
        <div class="item_grup">
            <a href="/{{session('locale')}}/{{$banner['link']}}">
        <div class="item_bann banner_nume">@if(session('locale') === 'ro'){{ $banner['name'] }} @else {{ $banner['name_ru'] }} @endif</div>
        <div class="item_bann small">@if(session('locale') === 'ro'){{ $banner['desc'] }} @else {{ $banner['desc_ru'] }} @endif</div>
            </a>
    </div>
</div>
</div>
    @endforeach
</div>
