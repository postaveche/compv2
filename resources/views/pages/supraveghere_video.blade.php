@extends('layouts.layouts')
@section('title', __('surveillance.meta_title'))
@section('description', __('surveillance.meta_description'))
@section('keywords', __('surveillance.meta_keywords'))
@section('img', asset('img/ai/surveillance/surveillance-service.svg'))
@push('structured_data')
@php
$pageUrl=url()->current();
$structuredData=['@context'=>'https://schema.org','@graph'=>[
 ['@type'=>'Service','@id'=>$pageUrl.'#service','name'=>__('surveillance.hero_title'),'description'=>__('surveillance.meta_description'),'url'=>$pageUrl,'image'=>asset('img/ai/surveillance/surveillance-service.svg'),'serviceType'=>__('surveillance.hero_title'),'provider'=>['@id'=>rtrim(url('/'),'/').'/#organization'],'areaServed'=>[['@type'=>'City','name'=>'Chișinău'],['@type'=>'Country','name'=>'Moldova']],'hasOfferCatalog'=>['@type'=>'OfferCatalog','name'=>__('surveillance.services_title'),'itemListElement'=>collect($services)->map(fn($item,$slug)=>['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>$item['title'],'description'=>$item['short'],'url'=>route('locale.supraveghere_service',['locale'=>app()->getLocale(),'service'=>$slug])]])->values()->all()]],
 ['@type'=>'BreadcrumbList','@id'=>$pageUrl.'#breadcrumb','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>__('surveillance.home'),'item'=>route('locale.acasa',app()->getLocale())],['@type'=>'ListItem','position'=>2,'name'=>__('surveillance.repairs'),'item'=>$pageUrl]]],
]];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@section('content')
<main class="laptop-page">
 <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa',app()->getLocale()) }}">@lang('surveillance.home')</a><span>›</span><span>@lang('surveillance.repairs')</span></nav>
 <section class="laptop-hero"><div class="laptop-hero__content"><span class="laptop-eyebrow">@lang('surveillance.eyebrow')</span><h1>@lang('surveillance.hero_title')</h1><p>@lang('surveillance.hero_text')</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('surveillance.call')</a><a class="btn btn-outline-secondary btn-lg" href="#servicii">@lang('surveillance.see_services')</a></div></div><img src="{{ asset('img/ai/surveillance/surveillance-service.svg') }}" alt="@lang('surveillance.hero_image_alt')" width="560" height="370"></section>
 <section id="servicii" class="laptop-section"><div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('surveillance.services_eyebrow')</span><h2>@lang('surveillance.services_title')</h2><p>@lang('surveillance.services_text')</p></div><div class="laptop-service-grid">@foreach($services as $slug=>$service)<article class="laptop-service-card">@include('block.surveillance_service_icon',['slug'=>$slug])<div class="laptop-service-card__content"><div class="laptop-service-card__top"><h3>{{ $service['title'] }}</h3><span class="laptop-service-card__number">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span></div><p>{{ $service['short'] }}</p><a href="{{ route('locale.supraveghere_service',['locale'=>app()->getLocale(),'service'=>$slug]) }}">@lang('surveillance.details') <span aria-hidden="true">→</span></a></div></article>@endforeach</div></section>
 <section class="laptop-process">@foreach(__('surveillance.process') as $step)<article>@include('block.repair_process_icon',['step'=>$loop->iteration])<div class="laptop-process__content"><strong>{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</strong><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div></article>@endforeach</section>
 <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('surveillance.cta_eyebrow')</span><h2>@lang('surveillance.cta_title')</h2></div><a class="btn btn-light btn-lg" href="{{ route('locale.contacte',app()->getLocale()) }}">@lang('surveillance.contacts')</a></section>
 @include('block.contactinfo') @include('block.maps')
</main>
@endsection
