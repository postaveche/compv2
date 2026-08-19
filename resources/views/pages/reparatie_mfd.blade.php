@extends('layouts.layouts')
@section('title', __('mfd.meta_title'))
@section('description', __('mfd.meta_description'))
@section('keywords', __('mfd.meta_keywords'))
@section('img', asset('img/rep_print.jpg'))

@section('content')
<main class="laptop-page">
    <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa', app()->getLocale()) }}">@lang('mfd.home')</a><span>›</span><a href="{{ route('locale.reincarcare', app()->getLocale()) }}">@lang('mfd.print_services')</a><span>›</span><span>@lang('mfd.repairs')</span></nav>
    <section class="laptop-hero">
        <div class="laptop-hero__content"><span class="laptop-eyebrow">@lang('mfd.eyebrow')</span><h1>@lang('mfd.hero_title')</h1><p>@lang('mfd.hero_text')</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="tel:+37360229129">@lang('mfd.call')</a><a class="btn btn-outline-secondary btn-lg" href="#servicii">@lang('mfd.see_services')</a></div></div>
        <img src="{{ asset('img/rep_print.jpg') }}" alt="@lang('mfd.hero_alt')" width="560" height="370">
    </section>
    <section id="servicii" class="laptop-section">
        <div class="laptop-section__heading"><span class="laptop-eyebrow">@lang('mfd.services_eyebrow')</span><h2>@lang('mfd.services_title')</h2><p>@lang('mfd.services_text')</p></div>
        <div class="laptop-service-grid">@foreach($services as $slug=>$service)<article class="laptop-service-card">@include('block.mfd_service_icon',['slug'=>$slug])<div class="laptop-service-card__content"><div class="laptop-service-card__top"><h3>{{ $service['title'] }}</h3><span class="laptop-service-card__number">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span></div><p>{{ $service['short'] }}</p><a href="{{ route('locale.mfd_service',['locale'=>app()->getLocale(),'service'=>$slug]) }}">@lang('mfd.details') <span aria-hidden="true">→</span></a></div></article>@endforeach</div>
    </section>
    <section class="laptop-process">@foreach(__('mfd.process') as $step)<article>@include('block.repair_process_icon',['step'=>$loop->iteration])<div class="laptop-process__content"><strong>{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</strong><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div></article>@endforeach</section>
    <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('mfd.cta_eyebrow')</span><h2>@lang('mfd.cta_title')</h2></div><a class="btn btn-light btn-lg" href="{{ route('locale.contacte',app()->getLocale()) }}">@lang('mfd.contacts')</a></section>
    @include('block.contactinfo') @include('block.maps')
</main>
@endsection
