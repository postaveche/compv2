@extends('layouts.layouts')

@section('title', __('specialist.title'))

@section('description', __('specialist.desc'))

@section('keywords', __('specialist.keys'))


@section('content')
    <div>
        @include('block.print_block')
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                <h1>@lang('specialist.h1')</h1>
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" style="max-width: 300px" src="/img/remont_comps.png"
                     alt="@lang('specialist.title')">
            </div>
        </div>
        <div class="content_block">
            <p>@lang('specialist.t1')</p>
            <p>@lang('specialist.t2')</p>
            <p>@lang('specialist.t3')</p>
            <p>@lang('specialist.t4')</p>
        </div>
        <p><strong>@lang('specialist.contact')</strong></p>
    </div>
    @include('block.contactinfo')
    @include('block.maps')
@endsection
