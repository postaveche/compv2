@extends('layouts.layouts')

@section('title', $service['title'].' '.__('tv.seo_title_location'))
@section('description', $service['short'].' '.__('tv.seo_description_suffix'))
@section('keywords', $service['title'].', '.__('tv.meta_keywords'))
@section('img', asset($serviceImage))

@push('structured_data')
@php
    $pageUrl=url()->current();
    $structuredData=['@context'=>'https://schema.org','@graph'=>[
        ['@type'=>'Service','@id'=>$pageUrl.'#service','name'=>$service['title'],'description'=>$service['intro'],'url'=>$pageUrl,'image'=>asset($serviceImage),'serviceType'=>$service['title'],'provider'=>['@id'=>rtrim(url('/'),'/').'/#organization'],'areaServed'=>['@type'=>'City','name'=>'Chișinău']],
        ['@type'=>'BreadcrumbList','@id'=>$pageUrl.'#breadcrumb','itemListElement'=>[
            ['@type'=>'ListItem','position'=>1,'name'=>__('tv.home'),'item'=>route('locale.acasa',app()->getLocale())],
            ['@type'=>'ListItem','position'=>2,'name'=>__('tv.repairs'),'item'=>route('locale.reparatii_televizoare',app()->getLocale())],
            ['@type'=>'ListItem','position'=>3,'name'=>$service['title'],'item'=>$pageUrl],
        ]],
    ]];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page laptop-detail">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa',app()->getLocale()) }}">@lang('tv.home')</a><span>›</span><a href="{{ route('locale.reparatii_televizoare',app()->getLocale()) }}">@lang('tv.repairs')</a><span>›</span><span>{{ $service['title'] }}</span></nav>
    <section class="laptop-detail-hero"><div><span class="laptop-eyebrow">@lang('tv.detail_eyebrow')</span><h1>{{ $service['title'] }}</h1><p>{{ $service['intro'] }}</p><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('tv.consultation')</a></div><img src="{{ asset($serviceImage) }}" alt="{{ $service['title'] }}" width="520" height="340"></section>
    <section class="laptop-service-highlights" aria-label="@lang('tv.important_info')"><aside class="laptop-diagnostic-banner"><span class="laptop-diagnostic-note__icon" aria-hidden="true">✓</span><span><strong>@lang('tv.diagnostic_title')</strong><small>@lang('tv.diagnostic_note')</small></span></aside><aside class="laptop-repair-time"><span class="laptop-repair-time__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span><strong>{{ $service['time']??__('tv.repair_time_title') }}</strong><small>{{ $service['warranty']??__('tv.repair_time_stock') }}</small>@if(!isset($service['time']))<small>@lang('tv.repair_time_order')</small>@endif</span></aside></section>
    <section class="laptop-service-description"><span class="laptop-eyebrow">@lang('tv.detail_eyebrow')</span><h2>@lang('tv.description_title')</h2>@foreach(__('tv.service_descriptions.'.$serviceSlug) as $paragraph)<p>{{ $paragraph }}</p>@endforeach</section>
    <section class="laptop-detail-grid"><article><span class="laptop-eyebrow">@lang('tv.symptoms_eyebrow')</span><h2>@lang('tv.symptoms_title')</h2><ul class="laptop-check-list">@foreach($service['symptoms'] as $symptom)<li>{{ $symptom }}</li>@endforeach</ul></article><article><span class="laptop-eyebrow">@lang('tv.steps_eyebrow')</span><h2>@lang('tv.steps_title')</h2><ol class="laptop-step-list">@foreach($service['steps'] as $step)<li><span>{{ $loop->iteration }}</span>{{ $step }}</li>@endforeach</ol></article></section>
    <aside class="laptop-info-box"><h2>@lang('tv.price_title')</h2><p>@lang('tv.price_text')</p><a href="tel:+37360229129">060 229 129</a></aside>
    <section class="laptop-more"><h2>@lang('tv.other_services')</h2><div class="laptop-more__links">@foreach($services as $slug=>$item)@if($slug!==$serviceSlug)<a href="{{ route('locale.tv_service',['locale'=>app()->getLocale(),'service'=>$slug]) }}">{{ $item['title'] }}</a>@endif @endforeach</div></section>
    <a class="laptop-back" href="{{ route('locale.reparatii_televizoare',app()->getLocale()) }}">← @lang('tv.all_services')</a>
</main>
@endsection
