@extends('layouts.layouts')

@section('title', __('contacte.contacte'))
@section('description', __('contacte.desc'))
@section('keywords', __('contacte.keys'))
@section('img', asset('img/ai/contact/contact-service.svg'))

@push('structured_data')
@php
$pageUrl=url()->current();
$structuredData=['@context'=>'https://schema.org','@type'=>'ContactPage','name'=>__('contacte.contacte'),'description'=>__('contacte.desc'),'url'=>$pageUrl,'image'=>asset('img/ai/contact/contact-service.svg'),'mainEntity'=>['@id'=>rtrim(url('/'),'/').'/#organization']];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page">
 <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa',app()->getLocale()) }}">@lang('contacte.home')</a><span>›</span><span>@lang('contacte.contacte')</span></nav>

 <section class="laptop-hero">
  <div class="laptop-hero__content"><span class="laptop-eyebrow">IT Service Grup S.R.L. · Comp.MD</span><h1>@lang('contacte.hero_title')</h1><p>@lang('contacte.hero_text')</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('contacte.call_now')</a><a class="btn btn-outline-secondary btn-lg" href="#harta">@lang('contacte.directions')</a></div></div>
  <img src="{{ asset('img/ai/contact/contact-service.svg') }}" alt="@lang('contacte.contacte')" width="560" height="370">
 </section>

 <section id="harta" class="contact-split">
  <div class="contact-split__map">@include('block.maps')</div>
  <div class="contact-split__info">
   <span class="laptop-eyebrow">@lang('contacte.contacte')</span><h2>@lang('contacte.details_title')</h2><p class="contact-split__lead">@lang('contacte.details_text')</p>
   <dl>
    <div><dt>@lang('contacte.adresa')</dt><dd>@lang('contacte.address_value') <a href="https://www.google.com/maps/search/?api=1&query=Comp.MD%2C%20Sarmizegetusa%2051%2C%20Chisinau" target="_blank" rel="noopener">@lang('contacte.directions') →</a></dd></div>
    <div><dt>@lang('contacte.tel')</dt><dd><a href="tel:+37360229129">060 229-129</a><span> · </span><a href="tel:+37378373736">078 37-37-36</a><span> · </span><a href="tel:+37367711444">0677-11-444</a></dd></div>
    <div><dt>@lang('contacte.email')</dt><dd><img src="{{ asset('mail.jpg') }}" alt="@lang('contacte.email')"><br><a href="{{ route('locale.rechizite_bancare',app()->getLocale()) }}">@lang('contacte.rechizite') →</a></dd></div>
    <div><dt>@lang('contacte.grafic')</dt><dd><strong>@lang('contacte.weekdays')</strong>, @lang('contacte.hours')<br><small>@lang('contacte.online_orders')</small></dd></div>
   </dl>
  </div>
 </section>

 <section class="contact-order-info"><article><span>01</span><div><h2>@lang('contacte.orders_title')</h2><p>@lang('contacte.desc1')</p></div></article><article><span>02</span><div><h2>@lang('contacte.stock_title')</h2><p>@lang('contacte.desc2')</p></div></article></section>

 <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('contacte.contacte')</span><h2>@lang('contacte.cta_title')</h2></div><a class="btn btn-light btn-lg" href="tel:+37360229129">060 229 129</a></section>
</main>
@endsection
