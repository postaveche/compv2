@extends('layouts.layouts')

@section('title', __('specialist.title'))
@section('description', __('specialist.desc'))
@section('keywords', __('specialist.keys'))
@section('img', asset('img/remont_comps.png'))

@push('structured_data')
@php
    $pageUrl = url()->current();
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => __('specialist.h1'),
        'description' => __('specialist.desc'),
        'url' => $pageUrl,
        'image' => asset('img/remont_comps.png'),
        'provider' => ['@id' => rtrim(url('/'), '/').'/#organization'],
        'areaServed' => ['@type' => 'City', 'name' => 'Chișinău'],
        'offers' => ['@type' => 'Offer', 'price' => '100', 'priceCurrency' => 'MDL'],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="specialist-page">
    <nav class="specialist-breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('specialist.home')</a>
        <span>›</span><span>@lang('specialist.title')</span>
    </nav>

    <section class="specialist-hero">
        <div class="specialist-hero__content">
            <span class="specialist-eyebrow">@lang('specialist.eyebrow')</span>
            <h1>@lang('specialist.h1')</h1>
            <p>@lang('specialist.t1')</p>
            <div class="specialist-actions">
                <a class="specialist-call" href="tel:+37360229129">@lang('specialist.call')</a>
                <a class="specialist-contact" href="#contacte">@lang('specialist.contact')</a>
            </div>
        </div>
        <div class="specialist-hero__visual">
            <span class="specialist-price"><small>@lang('specialist.price_label')</small><strong>100</strong><b>MDL</b></span>
            <img src="{{ asset('img/remont_comps.png') }}" width="500" height="390" alt="@lang('specialist.title')">
        </div>
    </section>

    <section class="specialist-details" aria-label="@lang('specialist.details_title')">
        <article><span>01</span><div><h2>@lang('specialist.card1_title')</h2><p>@lang('specialist.t2')</p></div></article>
        <article><span>02</span><div><h2>@lang('specialist.card2_title')</h2><p>@lang('specialist.t3')</p></div></article>
        <article><span>03</span><div><h2>@lang('specialist.card3_title')</h2><p>@lang('specialist.t4')</p></div></article>
    </section>

    <section id="contacte" class="specialist-cta">
        <div><span class="specialist-eyebrow">@lang('specialist.contact')</span><h2>@lang('specialist.cta_title')</h2></div>
        <a href="tel:+37360229129">060 229 129</a>
    </section>

    @include('block.contactinfo')
    @include('block.maps')
</main>
@endsection
