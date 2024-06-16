@extends('layouts.layouts')

@section('title', $product['name'])

@section('description', $product['description'])

@section('keywords', $product['keywords'])

@section('img', \Illuminate\Support\Facades\URL::to(Storage::url('public/products/'.$product_img[0]).'@800'))

@section('content')
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-8 justify-content-center">
                @include('block.breadcrumbs')
                <h1><b>@if(session('locale') == 'ru') {{$product['name_ru']}}@else {{$product['name_ro']}} @endif</b></h1>
                <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @for ($i = 0; $i<$product['img_qty']; $i++)
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}"
                                class="active" aria-current="true" aria-label="Foto {{$i}}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @foreach($product_img as $img)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <img src="{{Storage::url('public/products/'.$img)}}@800" class="d-block w-100 product_img"
                                     alt="{{$product['name']}}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
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
                <div class="product_contact">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                         class="bi bi-telephone-inbound-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    <div class="product_contact_nr"><span class="product_phone"> 060-229-129</span></div>
                </div>
                <div class="product_contact">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                         class="bi bi-phone" viewBox="0 0 16 16">
                        <path
                            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                    <div class="product_contact_nr"><span class="product_phone"> 067-711-444</span></div>
                </div>
                <hr>
                <div class="product_info_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-award" viewBox="0 0 16 16">
                        <path
                            d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z"/>
                        <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                    </svg>
                    <strong>@lang('product.garant'): {{$product['garantie']}} @lang('product.luni')</strong>
                </div>
                <div class="product_info_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-truck" viewBox="0 0 16 16">
                        <path
                            d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                    <strong>@lang('product.livrare')</strong>
                </div>
            </div>
            <div style="margin-top: 20px; padding-bottom: 15px">
                <strong>@lang('product.desc')</strong> {!!$product['text']!!}
            </div>
            <hr>
                @include('block.product_description')
            <div>
                <h3>@lang('product.similar')</h3>
                {{\App\Http\Controllers\ProductsController::recomandat($product['category_id'])}}
            </div>
        </div>
    </div>
@endsection
