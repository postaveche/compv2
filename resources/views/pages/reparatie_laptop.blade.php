@extends('layouts.layouts')

@section('title', __('laptop.meta_title'))
@section('description', __('laptop.meta_description'))
@section('keywords', __('laptop.meta_keywords'))
@section('img', asset('img/remont-noutbukov.jpg'))

@push('structured_data')
@php
    $laptopPageUrl = url()->current();
    $laptopStructuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Service',
                '@id' => $laptopPageUrl . '#service',
                'name' => __('laptop.hero_title'),
                'description' => __('laptop.meta_description'),
                'url' => $laptopPageUrl,
                'image' => asset('img/remont-noutbukov.jpg'),
                'serviceType' => __('laptop.hero_title'),
                'provider' => ['@id' => rtrim(url('/'), '/') . '/#organization'],
                'areaServed' => ['@type' => 'City', 'name' => 'Chișinău'],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => __('laptop.services_title'),
                    'itemListElement' => collect($services)->map(function ($item, $slug) {
                        return [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => $item['title'],
                                'description' => $item['short'],
                                'url' => route('locale.laptop_service', ['locale' => app()->getLocale(), 'service' => $slug]),
                            ],
                        ];
                    })->values()->all(),
                ],
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $laptopPageUrl . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => __('laptop.home'), 'item' => route('locale.acasa', app()->getLocale())],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => __('laptop.repairs'), 'item' => $laptopPageUrl],
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($laptopStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('laptop.home')</a><span>›</span><span>@lang('laptop.repairs')</span>
    </nav>

    <section class="laptop-hero">
        <div class="laptop-hero__content">
            <span class="laptop-eyebrow">@lang('laptop.eyebrow')</span>
            <h1>@lang('laptop.hero_title')</h1>
            <p>@lang('laptop.hero_text')</p>
            <div class="laptop-actions">
                <a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('laptop.call')</a>
                <a class="btn btn-outline-secondary btn-lg" href="#servicii">@lang('laptop.see_services')</a>
            </div>
        </div>
        <img src="{{ asset('img/ai/rep_nb.jpg') }}" alt="Reparație laptop în service" width="560" height="370">
    </section>

    <section id="servicii" class="laptop-section">
        <div class="laptop-section__heading">
            <span class="laptop-eyebrow">@lang('laptop.services_eyebrow')</span>
            <h2>@lang('laptop.services_title')</h2>
            <p>@lang('laptop.services_text')</p>
        </div>
        <div class="laptop-service-grid">
            @foreach($services as $slug => $service)
                <article class="laptop-service-card">
                    @include('block.laptop_service_icon', ['slug' => $slug])
                    <div class="laptop-service-card__content">
                        <div class="laptop-service-card__top">
                            <h3>{{ $service['title'] }}</h3>
                            <span class="laptop-service-card__number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <p>{{ $service['short'] }}</p>
                        <a href="{{ route('locale.laptop_service', ['locale' => app()->getLocale(), 'service' => $slug]) }}">@lang('laptop.details') <span aria-hidden="true">→</span></a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="laptop-process">
        @foreach(__('laptop.process') as $step)
            <div><strong>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</strong><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div>
        @endforeach
    </section>

    <section class="laptop-note">
        <div><span class="laptop-eyebrow">@lang('laptop.cta_eyebrow')</span><h2>@lang('laptop.cta_title')</h2></div>
        <a class="btn btn-light btn-lg" href="{{ route('locale.contacte', app()->getLocale()) }}">@lang('laptop.contacts')</a>
    </section>

    @include('block.contactinfo')
    @include('block.maps')
</main>
@endsection
