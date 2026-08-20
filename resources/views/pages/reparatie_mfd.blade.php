@extends('layouts.layouts')
@section('title', __('mfd.meta_title'))
@section('description', __('mfd.meta_description'))
@section('keywords', __('mfd.meta_keywords'))
@section('img', asset('img/rep_print.jpg'))

@push('structured_data')
@php
    $pageUrl = url()->current();
    $structuredData = ['@context'=>'https://schema.org','@graph'=>[
        ['@type'=>'Service','@id'=>$pageUrl.'#service','name'=>__('mfd.hero_title'),'description'=>__('mfd.meta_description'),'url'=>$pageUrl,'image'=>asset('img/rep_print.jpg'),'serviceType'=>__('mfd.hero_title'),'provider'=>['@id'=>rtrim(url('/'),'/').'/#organization'],'areaServed'=>['@type'=>'City','name'=>'Chișinău'],'hasOfferCatalog'=>['@type'=>'OfferCatalog','name'=>__('mfd.brands_title'),'itemListElement'=>collect($brands)->map(function($item,$slug){return ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>$item['title'],'url'=>route('locale.mfd_brand',['locale'=>app()->getLocale(),'brand'=>$slug])]];})->values()->all()]],
        ['@type'=>'BreadcrumbList','@id'=>$pageUrl.'#breadcrumb','itemListElement'=>[
            ['@type'=>'ListItem','position'=>1,'name'=>__('mfd.home'),'item'=>route('locale.acasa',app()->getLocale())],
            ['@type'=>'ListItem','position'=>2,'name'=>__('mfd.repairs'),'item'=>$pageUrl],
        ]],
    ]];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('mfd.home')</a><span>›</span><a href="{{ route('locale.reincarcare', app()->getLocale()) }}">@lang('mfd.print_services')</a><span>›</span><span>@lang('mfd.repairs')</span></nav>
    <section class="laptop-hero">
        <div class="laptop-hero__content"><span class="laptop-eyebrow">@lang('mfd.eyebrow')</span><h1>@lang('mfd.hero_title')</h1><p>@lang('mfd.hero_text')</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('mfd.call')</a><a class="btn btn-outline-secondary btn-lg" href="#servicii">@lang('mfd.see_services')</a></div></div>
        <img src="{{ asset('img/rep_print.jpg') }}" alt="@lang('mfd.hero_alt')" width="560" height="370">
    </section>
    <section id="producatori" class="mfd-brands laptop-section">
        <div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('mfd.brands_eyebrow')</span><h2>@lang('mfd.brands_title')</h2><p>@lang('mfd.brands_text')</p></div>
        <div class="mfd-brand-grid">@foreach($brands as $slug=>$brand)<a class="mfd-brand-card" href="{{ route('locale.mfd_brand',['locale'=>app()->getLocale(),'brand'=>$slug]) }}"><span class="mfd-brand-card__logo"><img src="{{ asset('img/companylogo/'.config('mfd_brand_logos.'.$slug)) }}" alt="{{ $brand['name'] }}" width="92" height="52" loading="lazy"></span><span><strong>{{ $brand['name'] }}</strong><small>{{ implode(' · ', array_column($brand['families'], 'name')) }}</small></span><b aria-hidden="true">→</b></a>@endforeach</div>
        <p class="mfd-brand-help">@lang('mfd.brand_not_listed') <a href="tel:+37360229129">@lang('mfd.call_short')</a></p>
    </section>
    <section id="servicii" class="laptop-section">
        <div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('mfd.services_eyebrow')</span><h2>@lang('mfd.services_title')</h2><p>@lang('mfd.services_text')</p></div>
        <div class="laptop-service-grid">@foreach($services as $slug=>$service)<article class="laptop-service-card">@include('block.mfd_service_icon',['slug'=>$slug])<div class="laptop-service-card__content"><div class="laptop-service-card__top"><h3>{{ $service['title'] }}</h3><span class="laptop-service-card__number">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span></div><p>{{ $service['short'] }}</p><a href="{{ route('locale.mfd_service',['locale'=>app()->getLocale(),'service'=>$slug]) }}">@lang('mfd.details') <span aria-hidden="true">→</span></a></div></article>@endforeach</div>
    </section>
    <div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('mfd.process_eyebrow')</span><h2>@lang('mfd.process_title')</h2><p>@lang('mfd.process_text')</p></div>
    <section class="laptop-process">@foreach(__('mfd.process') as $step)<article>@include('block.repair_process_icon',['step'=>$loop->iteration])<div class="laptop-process__content"><strong>{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</strong><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div></article>@endforeach</section>
    <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('mfd.cta_eyebrow')</span><h2>@lang('mfd.cta_title')</h2></div><a class="btn btn-light btn-lg" href="{{ route('locale.contacte',app()->getLocale()) }}">@lang('mfd.contacts')</a></section>
    @include('block.contactinfo') @include('block.maps')
</main>
@endsection
