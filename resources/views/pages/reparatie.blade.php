@extends('layouts.layouts')

@section('title', __('computer.hero_title'))
@section('description', __('computer.meta_description'))
@section('keywords', __('computer.meta_keywords'))
@section('img', asset('img/ai/pc/01-service-reparatii-calculatoare.webp'))

@push('structured_data')
@php
    $pageUrl = url()->current();
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Service', '@id' => $pageUrl.'#service', 'name' => __('computer.hero_title'),
                'description' => __('computer.meta_description'), 'url' => $pageUrl,
                'image' => asset('img/ai/pc/01-service-reparatii-calculatoare.webp'), 'serviceType' => __('computer.hero_title'),
                'provider' => ['@id' => rtrim(url('/'), '/').'/#organization'],
                'areaServed' => ['@type' => 'City', 'name' => 'Chișinău'],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog', 'name' => __('computer.services_title'),
                    'itemListElement' => collect($services)->map(function ($item, $slug) {
                        return ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service',
                            'name' => $item['title'], 'description' => $item['short'],
                            'url' => route('locale.computer_service', ['locale' => app()->getLocale(), 'service' => $slug])]];
                    })->values()->all(),
                ],
            ],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl.'#breadcrumb', 'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => __('computer.home'), 'item' => route('locale.acasa', app()->getLocale())],
                ['@type' => 'ListItem', 'position' => 2, 'name' => __('computer.repairs'), 'item' => $pageUrl],
            ]],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('computer.home')</a><span>›</span><span>@lang('computer.repairs')</span>
    </nav>
    <section class="laptop-hero">
        <div class="laptop-hero__content">
            <span class="laptop-eyebrow">@lang('computer.eyebrow')</span>
            <h1>@lang('computer.hero_title')</h1><p>@lang('computer.hero_text')</p>
            <div class="laptop-actions">
                <a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('computer.call')</a>
                <a class="btn btn-outline-secondary btn-lg" href="#servicii">@lang('computer.see_services')</a>
            </div>
        </div>
        <img src="{{ asset('img/ai/pc/01-service-reparatii-calculatoare.webp') }}" alt="@lang('computer.hero_image_alt')" width="560" height="370">
    </section>
    <section id="servicii" class="laptop-section">
        @php($featuredServices = array_slice($services, 0, 8, true))
        @php($specializedServices = array_slice($services, 8, null, true))
        <div class="laptop-section__heading">
            <span class="laptop-eyebrow">@lang('computer.services_eyebrow')</span><h2>@lang('computer.services_title')</h2><p>@lang('computer.services_text')</p>
        </div>
        <div class="laptop-service-grid">
            @foreach($featuredServices as $slug => $service)
                <article class="laptop-service-card">
                    @include('block.computer_service_icon', ['slug' => $slug])
                    <div class="laptop-service-card__content"><div class="laptop-service-card__top"><h3>{{ $service['title'] }}</h3><span class="laptop-service-card__number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></div>
                        <p>{{ $service['short'] }}</p><a href="{{ route('locale.computer_service', ['locale' => app()->getLocale(), 'service' => $slug]) }}">@lang('computer.details') <span aria-hidden="true">→</span></a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @if($specializedServices)
        <section class="laptop-specialized">
            <div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('computer.specialized_eyebrow')</span><h2>@lang('computer.specialized_title')</h2><p>@lang('computer.specialized_text')</p></div>
            <div class="laptop-specialized__grid">
                @foreach($specializedServices as $slug => $service)
                    <a href="{{ route('locale.computer_service', ['locale' => app()->getLocale(), 'service' => $slug]) }}">
                        @include('block.computer_service_icon', ['slug' => $slug])
                        <span class="laptop-specialized__content"><strong>{{ $service['title'] }}</strong><small>{{ $service['short'] }}</small></span><b aria-hidden="true">→</b>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
    <section class="laptop-process">
        @foreach(__('computer.process') as $step)
            <article>
                @include('block.repair_process_icon', ['step' => $loop->iteration])
                <div class="laptop-process__content"><strong>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</strong><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div>
            </article>
        @endforeach
    </section>
    <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('computer.cta_eyebrow')</span><h2>@lang('computer.cta_title')</h2></div><a class="btn btn-light btn-lg" href="{{ route('locale.contacte', app()->getLocale()) }}">@lang('computer.contacts')</a></section>
    @include('block.contactinfo')
    @include('block.maps')
</main>
@endsection
