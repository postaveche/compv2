@extends('layouts.layouts')

@php
    $locale = session('locale', 'ro');
    $pageTitle = $locale == 'ru' ? ($product['name_ru'] ?? $product['name']) : ($product['name_ro'] ?? $product['name']);
    $pageDesc = $locale == 'ru' ? ($product['description_ru'] ?? $product['description']) : $product['description'];
@endphp

@section('title', $pageTitle)

@section('description', $pageDesc)

@section('keywords', $product['keywords'])

@section('img', \Illuminate\Support\Facades\URL::to(Storage::url('public/products/'.$product_img[0]).'@800'))

@section('content')
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-8 justify-content-center">
                @include('block.breadcrumbs')
                <h1 class="product-title">@if(session('locale') == 'ru') {{$product['name_ru']}}@else {{$product['name_ro']}} @endif</h1>
                
                <!-- Product Gallery -->
                <div class="product-gallery">
                    <div class="product-main-image" id="mainImageWrap">
                        <img src="{{Storage::url('public/products/'.$product_img[0])}}{{(config('app.env') === 'production' ? '@800' : '')}}" 
                             class="product-main-img" id="mainImage" alt="{{ $pageTitle }}">
                        <img src="/logo.png" class="product-watermark" alt="">
                    </div>
                    @if(count($product_img) > 1)
                    <div class="product-thumbs">
                        @foreach($product_img as $idx => $img)
                        <div class="product-thumb {{ $idx == 0 ? 'active' : '' }}" 
                             onclick="changeMainImage(this, '{{Storage::url('public/products/'.$img)}}{{(config('app.env') === 'production' ? '@800' : '')}}')">
                            <img src="{{Storage::url('public/products/'.$img)}}{{(config('app.env') === 'production' ? '@800' : '')}}" alt="{{ $pageTitle }} foto {{ $idx+1 }}">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Lightbox -->
                <div class="product-lightbox" id="lightbox" onclick="closeLightbox()">
                    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
                    <button class="lightbox-prev" onclick="event.stopPropagation();lightboxNav(-1)">&#10094;</button>
                    <div class="lightbox-img-wrap" onclick="event.stopPropagation()">
                        <img src="" id="lightboxImg" class="lightbox-img">
                        <img src="/logo.png" class="lightbox-watermark">
                    </div>
                    <button class="lightbox-next" onclick="event.stopPropagation();lightboxNav(1)">&#10095;</button>
                    <div class="lightbox-counter" id="lightboxCounter"></div>
                </div>

                <style>
                .product-gallery { margin-bottom: 20px; }
                .product-title {
                    font-size: 1.4rem;
                    font-weight: 700;
                    color: #2c3e50;
                    margin-bottom: 15px;
                    padding-bottom: 10px;
                    border-bottom: 2px solid #f0f0f0;
                    line-height: 1.3;
                }
                @media (max-width: 576px) {
                    .product-title { font-size: 1.1rem; }
                }
                .product-main-image {
                    position: relative;
                    overflow: hidden;
                    border: 1px solid #eee;
                    border-radius: 8px;
                    background: #fff;
                    cursor: zoom-in;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .product-main-img {
                    max-width: 100%;
                    max-height: 55vh;
                    object-fit: contain;
                    transition: transform 0.3s ease;
                }
                .product-main-image:hover .product-main-img { transform: scale(1.05); }
                .product-watermark {
                    position: absolute;
                    bottom: 10px;
                    right: 10px;
                    height: 25px;
                    opacity: 0.4;
                    pointer-events: none;
                }
                .product-thumbs {
                    display: flex;
                    gap: 8px;
                    margin-top: 10px;
                    overflow-x: auto;
                    padding-bottom: 5px;
                }
                .product-thumb {
                    width: 70px;
                    height: 70px;
                    border: 2px solid #e0e0e0;
                    border-radius: 6px;
                    overflow: hidden;
                    cursor: pointer;
                    flex-shrink: 0;
                    transition: border-color 0.2s;
                }
                .product-thumb:hover, .product-thumb.active { border-color: #0d6efd; }
                .product-thumb img { width: 100%; height: 100%; object-fit: cover; }
                
                .product-lightbox {
                    display: none;
                    position: fixed;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(0,0,0,0.9);
                    z-index: 9999;
                    align-items: center;
                    justify-content: center;
                }
                .product-lightbox.open { display: flex; }
                .lightbox-img { max-width: 90%; max-height: 90vh; object-fit: contain; border-radius: 4px; display: block; }
                .lightbox-img-wrap {
                    position: relative;
                    max-width: 90%;
                    max-height: 90vh;
                    line-height: 0;
                }
                .lightbox-img-wrap .lightbox-img {
                    max-width: 100%;
                    max-height: 90vh;
                }
                .lightbox-close {
                    position: absolute; top: 15px; right: 25px;
                    color: #fff; font-size: 35px; cursor: pointer;
                    background: none; border: none; z-index: 10;
                }
                .lightbox-prev, .lightbox-next {
                    position: absolute; top: 50%; transform: translateY(-50%);
                    color: #fff; font-size: 30px; cursor: pointer;
                    background: rgba(255,255,255,0.15); border: none;
                    padding: 15px 12px; border-radius: 4px;
                }
                .lightbox-prev { left: 15px; }
                .lightbox-next { right: 15px; }
                .lightbox-prev:hover, .lightbox-next:hover { background: rgba(255,255,255,0.3); }
                .lightbox-counter {
                    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
                    color: #ccc; font-size: 14px;
                }
                .lightbox-watermark {
                    position: absolute;
                    bottom: 8px;
                    right: 8px;
                    height: 25px;
                    opacity: 0.4;
                    pointer-events: none;
                }
                @media (max-width: 576px) {
                    .product-thumb { width: 55px; height: 55px; }
                    .product-main-image { max-height: none; }
                    .product-main-img { max-height: 45vh; }
                }
                </style>

                <script>
                var productImages = @json(collect($product_img)->map(function($img) { return Storage::url('public/products/'.$img) . (config('app.env') === 'production' ? '@800' : ''); })->values());
                var currentLightboxIdx = 0;

                function changeMainImage(thumb, src) {
                    document.getElementById('mainImage').src = src;
                    document.querySelectorAll('.product-thumb').forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                }

                document.getElementById('mainImageWrap').addEventListener('click', function() {
                    var currentSrc = document.getElementById('mainImage').src;
                    currentLightboxIdx = productImages.findIndex(s => currentSrc.includes(s.split('/').pop()));
                    if (currentLightboxIdx < 0) currentLightboxIdx = 0;
                    openLightbox(currentLightboxIdx);
                });

                function openLightbox(idx) {
                    currentLightboxIdx = idx;
                    document.getElementById('lightboxImg').src = productImages[idx];
                    document.getElementById('lightboxCounter').textContent = (idx+1) + ' / ' + productImages.length;
                    document.getElementById('lightbox').classList.add('open');
                    document.body.style.overflow = 'hidden';
                }

                function closeLightbox() {
                    document.getElementById('lightbox').classList.remove('open');
                    document.body.style.overflow = '';
                }

                function lightboxNav(dir) {
                    currentLightboxIdx += dir;
                    if (currentLightboxIdx < 0) currentLightboxIdx = productImages.length - 1;
                    if (currentLightboxIdx >= productImages.length) currentLightboxIdx = 0;
                    document.getElementById('lightboxImg').src = productImages[currentLightboxIdx];
                    document.getElementById('lightboxCounter').textContent = (currentLightboxIdx+1) + ' / ' + productImages.length;
                }

                document.addEventListener('keydown', function(e) {
                    if (!document.getElementById('lightbox').classList.contains('open')) return;
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowLeft') lightboxNav(-1);
                    if (e.key === 'ArrowRight') lightboxNav(1);
                });
                </script>
            </div>
            <div class="col-sm-4">
                <div class="product_right">
                    <div class="d-flex flex-row-reverse">
                        <small><b>@lang('product.cod')</b> {{$product['sku']}}</small>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        @if($product['active'] == '0')
                            <small class="alert-danger stoc_box"><b>@lang('product.nostoc')</b></small>
                        @elseif($product['active'] == '1')
                            <small class="alert-success stoc_box"><b>@lang('product.stoc')</b></small>
                        @endif
                    </div>

                    {{\App\Http\Controllers\ProductsController::price($product['price'])}}

                    <small>@lang('product.incltva')</small>
                </div>
                <hr>
                <div class="product-phones">
                    <div class="product-phones-label">@lang('product.livrare')</div>
                    <a href="tel:060229129" class="product-phone-nr">060 229-129</a>
                    <a href="tel:0677111444" class="product-phone-nr">067 711-444</a>
                </div>
                <hr>
                <div class="product_info_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z"/>
                        <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                    </svg>
                    <strong>@lang('product.garant'): {{$product['garantie']}} @lang('product.luni')</strong>
                </div>
                <div class="product_info_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                    <strong>@lang('product.livrare')</strong>
                </div>
            </div>

            <style>
            .product_right {
                background: #fff;
                border: 2px solid #f0f0f0;
                border-radius: 12px;
                padding: 20px;
                border-top: 3px solid #ff6b35;
            }
            .product_price { color: #ff6b35 !important; }
            .product_price .price_small { color: #888 !important; }
            .product-phones { margin-bottom: 10px; }
            .product-phones-label { font-size: 0.8rem; color: #ff6b35; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
            .product-phone-nr {
                display: block;
                font-size: 1.3rem;
                font-weight: 700;
                color: #2c3e50;
                text-decoration: none;
                line-height: 1.6;
            }
            .product-phone-nr:hover { color: #ff6b35; }
            .product_info_icon { 
                display: flex; 
                align-items: center; 
                gap: 10px; 
                padding: 8px 0;
            }
            .product_info_icon svg { color: #ff6b35; fill: #ff6b35; flex-shrink: 0; }
            .stoc_box { padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; }
            </style>
            <div style="margin-top: 20px; padding-bottom: 15px">
                <strong>@lang('product.desc')</strong>
                @if(session('locale') == 'ru')
                    {!!$product['text_ru']!!}
                @else
                    {!!$product['text']!!}
                @endif
            </div>
            <hr>
                @include('block.product_description')
            <div>
                <h3>@lang('product.similar')</h3>
                {{\App\Http\Controllers\ProductsController::recomandat($product['category_id'])}}
            </div>
            <hr>
            <div>
                {{\App\Http\Controllers\MainController::HomeBanners()}}
            </div>
        </div>
    </div>
@endsection
