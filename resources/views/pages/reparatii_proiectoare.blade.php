@extends('layouts.layouts')

@section('title', __('remont_proiector.title'))

@section('description', __('remont_proiector.desc'))

@section('keywords', __('remont_proiector.keys'))

@section('content')
<div class="wrapper">
    <div class="reincarc_index">
        <div class="reincarc_item reincarc_text">
            @lang('remont_proiector.title1')
            <a href="tel:+37360229129" class="btn btn-secondary btn_call"><i class="fal fa-phone-alt"></i>@lang('reincarcare.call')</a>
        </div>
        <div class="reincarc_item reincar_photo">
            <img class="reincar_photo_img" src="/img/projector-all-kv-m.avif" alt="@lang('remont_proiector.title1')">
        </div>
    </div>
    <h1>@lang('remont_proiector.h1')</h1>
    <p>@lang('remont_proiector.t1')</p>
    <h2>@lang('remont_proiector.h2')</h2>
    <ul>
        <li>@lang('remont_proiector.l1')</li>
        <li>@lang('remont_proiector.l2')</li>
        <li>@lang('remont_proiector.l3')</li>
        <li>@lang('remont_proiector.l4')</li>
        <li>@lang('remont_proiector.l5')</li>
        <li>@lang('remont_proiector.l6')</li>
        <li>@lang('remont_proiector.l7')</li>
        <li>@lang('remont_proiector.l8')</li>
    </ul>
    <p><b>@lang('remont_proiector.dece')</b></p>
    <ul>
        <li>@lang('remont_proiector.dl1')</li>
        <li>@lang('remont_proiector.dl2')</li>
        <li>@lang('remont_proiector.dl3')</li>
        <li>@lang('remont_proiector.dl4')</li>
        <li>@lang('remont_proiector.dl5')</li>
    </ul>
    <p>@lang('remont_proiector.fin')</p>
    <div class="reincarc_index">
        <div class="reincarc_item reincarc_photo">
            <img class="reincar_photo_img" src="/img/proiectoare2.png" alt="@lang('remont_proiector.title1')">
        </div>
        <div class="reincarc_item reincarc_text">
            @lang('remont_print.title2')
            <a href="tel:+37360229129" class="btn btn-secondary btn_call"><i class="fal fa-phone-alt"></i>@lang('reincarcare.call')</a>
        </div>
    </div>
</div>
@endsection
