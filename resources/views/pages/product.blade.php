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

                function openPhonePopup(local, intl) {
                    document.getElementById('phonePopupNumber').textContent = local.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2-$3');
                    document.getElementById('popupCall').href = 'tel:' + local;
                    document.getElementById('popupTelegram').href = 'https://t.me/' + intl;
                    document.getElementById('popupViber').href = 'viber://chat?number=' + encodeURIComponent(intl);
                    document.getElementById('popupWhatsapp').href = 'https://wa.me/' + intl.replace('+', '');
                    document.getElementById('phonePopup').classList.add('open');
                }
                function closePhonePopup() {
                    document.getElementById('phonePopup').classList.remove('open');
                }
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') closePhonePopup();
                });
                </script>
            </div>
            <div class="col-sm-4">
                <div class="product_right">
                    <div class="d-flex justify-content-between">
                        <small><b>Articul:</b> {{$product['sku']}}</small>
                        <small><b>@lang('product.cod')</b> {{$product['id']}}</small>
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
                @php $isOnline = \App\Models\WorkSchedule::isOnlineNow(); @endphp
                <div class="product-phones">
                    <div class="product-phones-label">
                        <span class="status-dot {{ $isOnline ? 'online' : 'offline' }}"></span>
                        {{ $isOnline ? 'Suntem online' : 'Momentan offline' }}
                    </div>
                    <a href="#" class="product-phone-nr" onclick="event.preventDefault();openPhonePopup('060229129', '+37360229129')">
                        <span class="status-dot {{ $isOnline ? 'online' : 'offline' }}"></span>
                        060 229-129
                    </a>
                    <a href="#" class="product-phone-nr" onclick="event.preventDefault();openPhonePopup('0677111444', '+37367711444')">
                        <span class="status-dot {{ $isOnline ? 'online' : 'offline' }}"></span>
                        067 711-444
                    </a>
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
            .product-phones { margin-bottom: 10px; text-align: center; }
            .product-phones-label { font-size: 0.8rem; color: #ff6b35; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 6px; }
            .product-phone-nr {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                font-size: 1.3rem;
                font-weight: 700;
                color: #2c3e50;
                text-decoration: none;
                line-height: 1.6;
            }
            .product-phone-nr:hover { color: #ff6b35; cursor: pointer; }
            .phone-popup-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 9999;
                align-items: center;
                justify-content: center;
            }
            .phone-popup-overlay.open { display: flex; }
            .phone-popup {
                background: #fff;
                border-radius: 16px;
                padding: 30px;
                width: 320px;
                text-align: center;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                animation: popupIn 0.2s ease;
            }
            @keyframes popupIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
            .phone-popup-title { font-size: 1.4rem; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }
            .phone-popup-options { display: flex; flex-direction: column; gap: 10px; }
            .phone-option {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 16px;
                border-radius: 10px;
                text-decoration: none;
                font-size: 1rem;
                font-weight: 500;
                color: #fff;
                background: #333;
                transition: transform 0.15s;
            }
            .phone-option:hover { transform: scale(1.03); color: #fff; }
            .phone-option.tg { background: #0088cc; }
            .phone-option.vb { background: #7360f2; }
            .phone-option.wa { background: #25d366; }
            .phone-popup-close {
                margin-top: 15px;
                background: none;
                border: none;
                color: #999;
                font-size: 0.9rem;
                cursor: pointer;
            }
            .phone-popup-close:hover { color: #333; }
            .product_info_icon { 
                display: flex; 
                align-items: center; 
                gap: 10px; 
                padding: 8px 0;
            }
            .product_info_icon svg { color: #ff6b35; fill: #ff6b35; flex-shrink: 0; }
            .stoc_box { padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; }
            .status-dot {
                display: inline-block;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                flex-shrink: 0;
            }
            .status-dot.online {
                background: #2ecc71;
                box-shadow: 0 0 6px rgba(46, 204, 113, 0.6);
                animation: pulse-green 2s infinite;
            }
            .status-dot.offline { background: #e74c3c; }
            @keyframes pulse-green {
                0% { box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.5); }
                70% { box-shadow: 0 0 0 6px rgba(46, 204, 113, 0); }
                100% { box-shadow: 0 0 0 0 rgba(46, 204, 113, 0); }
            }
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

<!-- Phone popup -->
<div class="phone-popup-overlay" id="phonePopup" onclick="closePhonePopup()">
    <div class="phone-popup" onclick="event.stopPropagation()">
        <div class="phone-popup-title" id="phonePopupNumber"></div>
        <div class="phone-popup-options">
            <a href="#" id="popupCall" class="phone-option"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg><span>Apel telefonic</span></a>
            <a href="#" id="popupTelegram" target="_blank" class="phone-option tg"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.094.06.183.125.27.187.331.236.619.441.956.401.196-.023.399-.202.501-.764.241-1.33.715-4.215.826-5.39a2.015 2.015 0 0 0-.02-.317.721.721 0 0 0-.244-.448c-.15-.118-.353-.14-.443-.14-.423.008-.966.253-1.29.41z"/></svg><span>Telegram</span></a>
            <a href="#" id="popupViber" class="phone-option vb"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M11.176 14.429c-2.665 0-4.826-1.8-4.826-4.018 0-2.22 2.159-4.02 4.826-4.02S16 8.191 16 10.411c0 1.21-.65 2.301-1.666 3.036a.324.324 0 0 0-.12.366l.218.81a.616.616 0 0 1 .029.117.166.166 0 0 1-.162.162.2.2 0 0 1-.092-.03l-1.057-.61a.519.519 0 0 0-.256-.074.509.509 0 0 0-.142.021 5.668 5.668 0 0 1-1.576.22zM9.064 9.542a.647.647 0 1 0 .557-1 .645.645 0 0 0-.646.647.615.615 0 0 0 .09.353zm3.232.001a.646.646 0 1 0 .546-1 .645.645 0 0 0-.644.644.627.627 0 0 0 .098.356z"/><path d="M0 6.826c0 1.455.781 2.765 2.001 3.656a.385.385 0 0 1 .143.439l-.161.6-.1.373a.499.499 0 0 0-.032.14.192.192 0 0 0 .193.193c.039 0 .077-.01.111-.029l1.268-.733a.622.622 0 0 1 .308-.088c.058 0 .116.009.171.025a6.83 6.83 0 0 0 1.625.26 4.45 4.45 0 0 1-.177-1.251c0-2.936 2.785-5.02 5.824-5.02.05 0 .1 0 .15.002C10.587 3.429 8.392 2 5.796 2 2.596 2 0 4.16 0 6.826zm4.632-1.555a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0zm3.06 0a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0z"/></svg><span>Viber</span></a>
            <a href="#" id="popupWhatsapp" target="_blank" class="phone-option wa"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg><span>WhatsApp</span></a>
        </div>
        <button class="phone-popup-close" onclick="closePhonePopup()">Inchide</button>
    </div>
</div>
@endsection
