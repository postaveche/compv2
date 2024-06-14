@extends('layouts.layouts')

@section('title', __('reincarcare.title'))

@section('description', __('reincarcare.h1'))

@section('keywords', __('reincarcare.key'))

@section('content')
    <div>
        @include('block.print_block')
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                <h1>@lang('reincarcare.h1')</h1>
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/reincarc.png" alt="@lang('reincarcare.h1')">
            </div>
        </div>
        <div class="content_block">
            <p><strong>IT SERVICE GRUP SRL</strong> @lang('reincarcare.t1')</p>
            <p>- @lang('reincarcare.t2')<br/> - @lang('reincarcare.t3')</p>
            <p>- @lang('reincarcare.t4')<br/> - @lang('reincarcare.t5')</p>
            <p>@lang('reincarcare.t6')</p>
            <p>@lang('reincarcare.t7')<br/></p>
        </div>
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                @lang('reincarcare.h2')
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/can725.png" alt="@lang('reincarcare.h2')">
            </div>
        </div>
        <div class="content_block">
            <p>***@lang('reincarcare.t8')
            </p>
            <p>@lang('reincarcare.t9')
            </p>
        </div>
        <div class="reincarc_index">
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/ink.png" alt="@lang('reincarcare.h3')">
            </div>
            <div class="reincarc_item reincarc_text">
                @lang('reincarcare.h3')
            </div>
        </div>
        <div class="content_block">
            @include('block.contactinfo')
        </div>
    </div>
@endsection
