@extends('layouts.layouts')

@section('title', __('remont_print.title'))

@section('description', __('remont_print.desc'))

@section('keywords', __('remont_print.keys'))

@section('content')
    <div class="wrapper">
        @include('block.print_block')
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                @lang('remont_print.title1')
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/print_rep.png" alt="@lang('remont_print.print_rem')">
            </div>
        </div>
        <h1>@lang('remont_print.h1')</h1>
        <p>@lang('remont_print.t1')</p>
        <h2>@lang('remont_print.h2')</h2>
        <p>@lang('remont_print.t2')</p>
        <p><b>@lang('remont_print.type')</b></p>
        <ul>
            <li>
                <b>@lang('remont_print.l1b')</b> – @lang('remont_print.l1')
            </li>
            <li>
                <b>@lang('remont_print.l2b')</b> – @lang('remont_print.l2')
            </li>
            <li>
                <b>@lang('remont_print.l3b')</b> – @lang('remont_print.l3')
            </li>
        </ul>
        <p><b>@lang('remont_print.dece')</b></p>
        <ul>
            <li>
                @lang('remont_print.dl1')
            </li>
            <li>
                @lang('remont_print.dl2')
            </li>
            <li>
                @lang('remont_print.dl3')
            </li>
            <li>
                @lang('remont_print.dl4')
            </li>
        </ul>
        <p>@lang('remont_print.fin')</p>
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_photo">
                <img class="reincar_photo_img" src="/img/print_rep.png" alt="@lang('remont_print.print_rem')">
            </div>
            <div class="reincarc_item reincarc_text">
                @lang('remont_print.title2')
            </div>
        </div>
    </div>
@endsection
