@extends('layouts.layouts')

@section('title', __('tv.meta_title'))
@section('description', __('tv.meta_description'))
@section('keywords', __('tv.meta_keywords'))
@section('img', asset('img/ai/tv/tv-service.svg'))

@push('structured_data')
@php
    $pageUrl = url()->current();
    $structuredData = ['@context'=>'https://schema.org','@graph'=>[
        ['@type'=>'Service','@id'=>$pageUrl.'#service','name'=>__('tv.hero_title'),'description'=>__('tv.meta_description'),'url'=>$pageUrl,'image'=>asset('img/ai/tv/tv-service.svg'),'serviceType'=>__('tv.hero_title'),'provider'=>['@id'=>rtrim(url('/'),'/').'/#organization'],'areaServed'=>['@type'=>'City','name'=>'Chișinău'],'hasOfferCatalog'=>['@type'=>'OfferCatalog','name'=>__('tv.services_title'),'itemListElement'=>collect($services)->map(function($item,$slug){return ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>$item['title'],'description'=>$item['short'],'url'=>route('locale.tv_service',['locale'=>app()->getLocale(),'service'=>$slug])]];})->values()->all()]],
        ['@type'=>'BreadcrumbList','@id'=>$pageUrl.'#breadcrumb','itemListElement'=>[
            ['@type'=>'ListItem','position'=>1,'name'=>__('tv.home'),'item'=>route('locale.acasa',app()->getLocale())],
            ['@type'=>'ListItem','position'=>2,'name'=>__('tv.repairs'),'item'=>$pageUrl],
        ]],
    ]];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('tv.home')</a><span>›</span><span>@lang('tv.repairs')</span></nav>
    <section class="laptop-hero">
        <div class="laptop-hero__content"><span class="laptop-eyebrow">@lang('tv.eyebrow')</span><h1>@lang('tv.hero_title')</h1><p>@lang('tv.hero_text')</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('tv.call')</a><a class="btn btn-outline-secondary btn-lg" href="#servicii">@lang('tv.see_services')</a></div></div>
        <img src="{{ asset('img/ai/tv/tv-service.svg') }}" alt="@lang('tv.hero_image_alt')" width="560" height="370">
    </section>
    <section id="servicii" class="laptop-section">
        <div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('tv.services_eyebrow')</span><h2>@lang('tv.services_title')</h2><p>@lang('tv.services_text')</p></div>
        <div class="laptop-service-grid">
            @foreach($services as $slug=>$service)
                <article class="laptop-service-card">@include('block.tv_service_icon',['slug'=>$slug])<div class="laptop-service-card__content"><div class="laptop-service-card__top"><h3>{{ $service['title'] }}</h3><span class="laptop-service-card__number">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span></div><p>{{ $service['short'] }}</p><a href="{{ route('locale.tv_service',['locale'=>app()->getLocale(),'service'=>$slug]) }}">@lang('tv.details') <span aria-hidden="true">→</span></a></div></article>
            @endforeach
        </div>
    </section>
    <section class="laptop-process">@foreach(__('tv.process') as $step)<article>@include('block.repair_process_icon',['step'=>$loop->iteration])<div class="laptop-process__content"><strong>{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</strong><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div></article>@endforeach</section>
    <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('tv.cta_eyebrow')</span><h2>@lang('tv.cta_title')</h2></div><a class="btn btn-light btn-lg" href="{{ route('locale.contacte',app()->getLocale()) }}">@lang('tv.contacts')</a></section>
    @include('block.contactinfo')
    @include('block.maps')
</main>
@endsection
