@extends('layouts.layouts')
@section('title', $brand['meta_title'])
@section('description', $brand['meta_description'])
@section('keywords', $brand['keywords'])
@section('img', asset('img/rep_print.jpg'))

@push('structured_data')
@php
    $pageUrl = url()->current();
    $faqItems = collect($brand['faq'])->map(function ($item) {
        return ['@type'=>'Question','name'=>$item['question'],'acceptedAnswer'=>['@type'=>'Answer','text'=>$item['answer']]];
    })->values()->all();
    $structuredData = ['@context'=>'https://schema.org','@graph'=>[
        ['@type'=>'Service','@id'=>$pageUrl.'#service','name'=>$brand['title'],'description'=>$brand['meta_description'],'url'=>$pageUrl,'image'=>asset('img/rep_print.jpg'),'serviceType'=>$brand['title'],'provider'=>['@id'=>rtrim(url('/'),'/').'/#organization'],'areaServed'=>['@type'=>'City','name'=>'Chișinău'],'brand'=>['@type'=>'Brand','name'=>$brand['name']]],
        ['@type'=>'BreadcrumbList','@id'=>$pageUrl.'#breadcrumb','itemListElement'=>[
            ['@type'=>'ListItem','position'=>1,'name'=>__('mfd.home'),'item'=>route('locale.acasa',app()->getLocale())],
            ['@type'=>'ListItem','position'=>2,'name'=>__('mfd.repairs'),'item'=>route('locale.reparatie_mfd',app()->getLocale())],
            ['@type'=>'ListItem','position'=>3,'name'=>$brand['name'],'item'=>$pageUrl],
        ]],
        ['@type'=>'FAQPage','@id'=>$pageUrl.'#faq','mainEntity'=>$faqItems],
    ]];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page laptop-detail mfd-brand-page">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa',app()->getLocale()) }}">@lang('mfd.home')</a><span>›</span><a href="{{ route('locale.reparatie_mfd',app()->getLocale()) }}">@lang('mfd.repairs')</a><span>›</span><span>{{ $brand['name'] }}</span></nav>
    <section class="laptop-detail-hero"><div><span class="laptop-eyebrow">@lang('mfd.brand_eyebrow')</span><h1>{{ $brand['title'] }}</h1><p>{{ $brand['intro'] }}</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('mfd.call')</a><a class="btn btn-outline-secondary btn-lg" href="#modele">@lang('mfd.see_models')</a></div></div><div class="mfd-brand-visual mfd-brand-visual--logo" role="img" aria-label="{{ $brand['name'] }}" style="background-image: url('{{ asset('img/companylogo/'.config('mfd_brand_logos.'.$brandSlug)) }}')"></div></section>

    <section class="laptop-service-description"><span class="laptop-eyebrow">@lang('mfd.brand_service_eyebrow')</span><h2>@lang('mfd.brand_service_title',['brand'=>$brand['name']])</h2>@foreach($brand['description'] as $paragraph)<p>{{ $paragraph }}</p>@endforeach</section>

    <section id="modele" class="mfd-models laptop-section"><div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('mfd.models_eyebrow')</span><h2>@lang('mfd.models_title',['brand'=>$brand['name']])</h2><p>@lang('mfd.models_text')</p></div><div class="mfd-family-grid">@foreach($brand['families'] as $family)<article><h3>{{ $family['name'] }}</h3><div class="mfd-model-tags">@foreach($family['models'] as $model)<span>{{ $model }}</span>@endforeach</div></article>@endforeach</div><p class="mfd-model-note">@lang('mfd.model_not_listed',['brand'=>$brand['name']])</p></section>

    <section class="laptop-detail-grid"><article><span class="laptop-eyebrow">@lang('mfd.symptoms_eyebrow')</span><h2>@lang('mfd.brand_faults_title')</h2><ul class="laptop-check-list">@foreach($brand['faults'] as $fault)<li>{{ $fault }}</li>@endforeach</ul></article><article><span class="laptop-eyebrow">@lang('mfd.brand_services_eyebrow')</span><h2>@lang('mfd.brand_services_title')</h2><ul class="laptop-check-list">@foreach($brand['services'] as $service)<li>{{ $service }}</li>@endforeach</ul></article></section>

    <section class="mfd-faq"><span class="laptop-eyebrow">FAQ</span><h2>@lang('mfd.faq_title',['brand'=>$brand['name']])</h2>@foreach($brand['faq'] as $item)<details><summary>{{ $item['question'] }}</summary><p>{{ $item['answer'] }}</p></details>@endforeach</section>

    <aside class="laptop-info-box"><h2>@lang('mfd.price_title')</h2><p>@lang('mfd.price_text')</p><a href="tel:+37360229129">060 229 129</a></aside>
    <section class="laptop-more"><h2>@lang('mfd.other_brands')</h2><div class="laptop-more__links">@foreach($brands as $slug=>$item)@if($slug!==$brandSlug)<a href="{{ route('locale.mfd_brand',['locale'=>app()->getLocale(),'brand'=>$slug]) }}">{{ $item['name'] }}</a>@endif @endforeach</div></section>
    <a class="laptop-back" href="{{ route('locale.reparatie_mfd',app()->getLocale()) }}">← @lang('mfd.all_mfd_repairs')</a>
</main>
@endsection
