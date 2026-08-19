@extends('layouts.layouts')
@section('title', $service['title'].' '.__('mfd.seo_location'))
@section('description', $service['intro'])
@section('keywords', $service['title'].', '.__('mfd.meta_keywords'))
@section('img', asset('img/rep_print.jpg'))

@section('content')
<main class="laptop-page laptop-detail">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa',app()->getLocale()) }}">@lang('mfd.home')</a><span>›</span><a href="{{ route('locale.reparatie_mfd',app()->getLocale()) }}">@lang('mfd.repairs')</a><span>›</span><span>{{ $service['title'] }}</span></nav>
    <section class="laptop-detail-hero"><div><span class="laptop-eyebrow">@lang('mfd.detail_eyebrow')</span><h1>{{ $service['title'] }}</h1><p>{{ $service['intro'] }}</p><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('mfd.consultation')</a></div><img src="{{ asset('img/rep_print.jpg') }}" alt="{{ $service['title'] }}" width="520" height="340"></section>
    <section class="laptop-service-highlights"><aside class="laptop-diagnostic-banner"><span class="laptop-diagnostic-note__icon" aria-hidden="true">✓</span><span><strong>@lang('mfd.diagnostic_title')</strong><small>@lang('mfd.diagnostic_note')</small></span></aside><aside class="laptop-repair-time"><span><strong>{{ $service['time'] }}</strong><small>@lang('mfd.time_note')</small></span></aside></section>
    <section class="laptop-service-description"><span class="laptop-eyebrow">@lang('mfd.detail_eyebrow')</span><h2>@lang('mfd.description_title')</h2><p>{{ $service['description'] }}</p></section>
    <section class="laptop-detail-grid"><article><span class="laptop-eyebrow">@lang('mfd.symptoms_eyebrow')</span><h2>@lang('mfd.symptoms_title')</h2><ul class="laptop-check-list">@foreach($service['symptoms'] as $symptom)<li>{{ $symptom }}</li>@endforeach</ul></article><article><span class="laptop-eyebrow">@lang('mfd.steps_eyebrow')</span><h2>@lang('mfd.steps_title')</h2><ol class="laptop-step-list">@foreach($service['steps'] as $step)<li><span>{{ $loop->iteration }}</span>{{ $step }}</li>@endforeach</ol></article></section>
    <aside class="laptop-info-box"><h2>@lang('mfd.price_title')</h2><p>@lang('mfd.price_text')</p><a href="tel:+37360229129">060 229 129</a></aside>
    <section class="laptop-more"><h2>@lang('mfd.other_services')</h2><div class="laptop-more__links">@foreach($services as $slug=>$item)@if($slug!==$serviceSlug)<a href="{{ route('locale.mfd_service',['locale'=>app()->getLocale(),'service'=>$slug]) }}">{{ $item['title'] }}</a>@endif @endforeach</div></section>
    <a class="laptop-back" href="{{ route('locale.reparatie_mfd',app()->getLocale()) }}">← @lang('mfd.all_services')</a>
</main>
@endsection
