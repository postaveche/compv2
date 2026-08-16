@extends('layouts.layouts')

@section('title', __('bank_details.meta_title'))
@section('description', __('bank_details.meta_description'))
@section('keywords', __('bank_details.meta_keywords'))
@section('img', asset('img/ai/contact/bank-details.svg'))

@push('structured_data')
@php
$structuredData=['@context'=>'https://schema.org','@type'=>'AboutPage','name'=>__('bank_details.hero_title'),'description'=>__('bank_details.meta_description'),'url'=>url()->current(),'mainEntity'=>['@id'=>rtrim(url('/'),'/').'/#organization']];
@endphp
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<main class="laptop-page bank-page">
 <nav class="laptop-breadcrumb" aria-label="breadcrumb"><a href="{{ route('locale.acasa',app()->getLocale()) }}">@lang('bank_details.home')</a><span>›</span><span>@lang('bank_details.title')</span></nav>
 <section class="laptop-hero"><div class="laptop-hero__content"><span class="laptop-eyebrow">@lang('bank_details.eyebrow')</span><h1>@lang('bank_details.hero_title')</h1><p>@lang('bank_details.hero_text')</p><div class="laptop-actions"><a class="btn btn-danger btn-lg" href="{{ route('locale.contacte',app()->getLocale()) }}">@lang('bank_details.contact')</a></div></div><img src="{{ asset('img/ai/contact/bank-details.svg') }}" alt="@lang('bank_details.hero_title')" width="560" height="370"></section>

 <section class="bank-details">
  <article><div class="bank-details__heading"><span class="laptop-service-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 11 12 3l9 8"/><path d="M5 10v10h14V10M9 20v-6h6v6"/></svg></span><div><span class="laptop-eyebrow">01</span><h2>@lang('bank_details.company_details')</h2></div></div><dl><div><dt>@lang('bank_details.company_name')</dt><dd>@lang('bank_details.company_value')</dd></div><div><dt>@lang('bank_details.legal_address')</dt><dd>@lang('bank_details.address_value')</dd></div><div><dt>@lang('bank_details.fiscal_code')</dt><dd class="bank-code">1010600045304</dd></div><div><dt>@lang('bank_details.vat_code')</dt><dd class="bank-code">0608553</dd></div></dl></article>
  <article><div class="bank-details__heading"><span class="laptop-service-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 9h18M5 9v9M9 9v9M15 9v9M19 9v9M3 19h18M2 22h20M12 2l10 5H2z"/></svg></span><div><span class="laptop-eyebrow">02</span><h2>@lang('bank_details.bank_details')</h2></div></div><dl><div><dt>@lang('bank_details.iban')</dt><dd class="bank-code bank-code--large">MD47MO2224ASV84387867100</dd></div><div><dt>@lang('bank_details.bank')</dt><dd>Mobiasbanca – Groupe Société Générale S.A.</dd></div><div><dt>@lang('bank_details.bic')</dt><dd class="bank-code">MOBBMD22</dd></div></dl></article>
 </section>

 <section class="laptop-note"><div><span class="laptop-eyebrow">@lang('bank_details.note_text')</span><h2>@lang('bank_details.note_title')</h2></div><a class="btn btn-light btn-lg" href="{{ route('locale.contacte',app()->getLocale()) }}">@lang('bank_details.back_contacts')</a></section>
</main>
@endsection
