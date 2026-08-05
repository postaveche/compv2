@extends('layouts.layouts')

@section('title', $service['title'] . ' - ' . __('laptop.meta_title'))
@section('description', $service['short'] . ' ' . __('laptop.meta_description'))
@section('keywords', $service['title'] . ', ' . __('laptop.meta_keywords'))
@section('img', asset($serviceImage))

@push('structured_data')
@php
    $servicePageUrl = url()->current();
    $serviceStructuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Service',
                '@id' => $servicePageUrl . '#service',
                'name' => $service['title'],
                'description' => $service['intro'],
                'url' => $servicePageUrl,
                'image' => asset($serviceImage),
                'serviceType' => $service['title'],
                'provider' => ['@id' => rtrim(url('/'), '/') . '/#organization'],
                'areaServed' => ['@type' => 'City', 'name' => 'Chișinău'],
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $servicePageUrl . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => __('laptop.home'), 'item' => route('locale.acasa', app()->getLocale())],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => __('laptop.repairs'), 'item' => route('locale.reparatie_laptop', app()->getLocale())],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $service['title'], 'item' => $servicePageUrl],
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($serviceStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page laptop-detail">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('laptop.home')</a><span>›</span>
        <a href="{{ route('locale.reparatie_laptop', app()->getLocale()) }}">@lang('laptop.repairs')</a><span>›</span>
        <span>{{ $service['title'] }}</span>
    </nav>

    <section class="laptop-detail-hero">
        <div>
            <span class="laptop-eyebrow">@lang('laptop.detail_eyebrow')</span>
            <h1>{{ $service['title'] }}</h1>
            <p>{{ $service['intro'] }}</p>
            <a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('laptop.consultation')</a>
        </div>
        <img src="{{ asset($serviceImage) }}" alt="{{ $service['title'] }}" width="520" height="340">
    </section>

    <section class="laptop-service-highlights" aria-label="@lang('laptop.important_info')">
        <aside class="laptop-diagnostic-banner">
            <span class="laptop-diagnostic-note__icon" aria-hidden="true">✓</span>
            <span><strong>@lang('laptop.diagnostic_title')</strong><small>@lang('laptop.diagnostic_note')</small></span>
        </aside>
        <aside class="laptop-repair-time">
            <span class="laptop-repair-time__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            </span>
            <span>
                <strong>@lang('laptop.repair_time_title')</strong>
                <small>@lang('laptop.repair_time_stock')</small>
                <small>@lang('laptop.repair_time_order')</small>
            </span>
        </aside>
    </section>

    <section class="laptop-service-description">
        <span class="laptop-eyebrow">@lang('laptop.detail_eyebrow')</span>
        <h2>@lang('laptop.description_title')</h2>
        @foreach(__('laptop.service_descriptions.' . $serviceSlug) as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </section>

    <section class="laptop-detail-grid">
        <article>
            <span class="laptop-eyebrow">@lang('laptop.symptoms_eyebrow')</span>
            <h2>@lang('laptop.symptoms_title')</h2>
            <ul class="laptop-check-list">
                @foreach($service['symptoms'] as $symptom)<li>{{ $symptom }}</li>@endforeach
            </ul>
        </article>
        <article>
            <span class="laptop-eyebrow">@lang('laptop.steps_eyebrow')</span>
            <h2>@lang('laptop.steps_title')</h2>
            <ol class="laptop-step-list">
                @foreach($service['steps'] as $step)<li><span>{{ $loop->iteration }}</span>{{ $step }}</li>@endforeach
            </ol>
        </article>
    </section>

    <aside class="laptop-info-box">
        <h2>@lang('laptop.price_title')</h2>
        <p>@lang('laptop.price_text')</p>
        <a href="tel:+37360229129">060 229 129</a>
    </aside>

    <section class="laptop-more">
        <h2>@lang('laptop.other_services')</h2>
        <div class="laptop-more__links">
            @foreach($services as $slug => $item)
                @if($slug !== $serviceSlug)<a href="{{ route('locale.laptop_service', ['locale' => app()->getLocale(), 'service' => $slug]) }}">{{ $item['title'] }}</a>@endif
            @endforeach
        </div>
    </section>

    <a class="laptop-back" href="{{ route('locale.reparatie_laptop', app()->getLocale()) }}">← @lang('laptop.all_services')</a>
</main>
@endsection
