@extends('layouts.layouts')

@section('title', __('remont_aspirator.title'))

@section('description', __('remont_aspirator.desc'))

@section('keywords', __('remont_aspirator.keys'))

@section('content')
<div class="wrapper">
    <div class="reincarc_index">
        <div class="reincarc_item reincarc_text">
            @lang('remont_aspirator.title1')
            <a href="tel:+37360229129" class="btn btn-secondary btn_call"><i class="fal fa-phone-alt"></i>@lang('reincarcare.call')</a>
        </div>
        <div class="reincarc_item reincar_photo">
            <img class="reincar_photo_img" src="/img/roborock300.png" alt="@lang('remont_aspirator.title1')">
        </div>
    </div>
    <h1>@lang('remont_aspirator.h1')</h1>
    <p>@lang('remont_aspirator.t1')</p>
    <h2>@lang('remont_aspirator.h2')</h2>
    <ul>
        <li>@lang('remont_aspirator.l1')</li>
        <li>@lang('remont_aspirator.l2')</li>
        <li>@lang('remont_aspirator.l3')</li>
        <li>@lang('remont_aspirator.l4')</li>
        <li>@lang('remont_aspirator.l5')</li>
        <li>@lang('remont_aspirator.l6')</li>
        <li>@lang('remont_aspirator.l7')</li>
    </ul>
    <p><b>@lang('remont_aspirator.m_title')</b></p>
    <p>@lang('remont_aspirator.m_desc')</p>
    <ul>
        <li><b>iRobot Roomba</b> (seriile 600, 800, 900, i7, s9)</li>
        <li><b>Xiaomi Roborock </b>(S5, S6, S7, Q7, MaxV)</li>
        <li><b>Ecovacs Deebot </b>(N8, T9, X1)</li>
        <li><b>Dreame </b>(L10, D9, Z10 Pro)</li>
        <li><b>Samsung PowerBot</b></li>
        <li><b>Neato Botvac</b></li>
        <li><b>Proscenic M7, M8</b></li>
        <li><b>Eufy RoboVac</b></li>
        <li><b>Mamibot, ILIFE</b></li>
    </ul>
    <p>@lang('remont_aspirator.m_desc2')</p>
    <p><b>@lang('remont_aspirator.dece')</b></p>
    <ul>
        <li>@lang('remont_aspirator.dl1')</li>
        <li>@lang('remont_aspirator.dl2')</li>
        <li>@lang('remont_aspirator.dl3')</li>
        <li>@lang('remont_aspirator.dl4')</li>
        <li>@lang('remont_aspirator.dl5')</li>
    </ul>
    <p>@lang('remont_aspirator.fin')</p>
    <div class="reincarc_index">
        <div class="reincarc_item reincarc_photo">
            <img class="reincar_photo_img" src="/img/philpipsrobo.avif" alt="@lang('remont_aspirator.title1')">
        </div>
        <div class="reincarc_item reincarc_text">
            @lang('remont_print.title2')
            <a href="tel:+37360229129" class="btn btn-secondary btn_call"><i class="fal fa-phone-alt"></i>@lang('reincarcare.call')</a>
        </div>
    </div>
</div>
@endsection
