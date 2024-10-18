@extends('layouts.layouts')

@section('title', __('contacte.contacte'))

@section('description', __('contacte.desc'))

@section('keywords', __('contacte.keys'))

@section('content')
    <h1>@lang('contacte.contacte')</h1>
    @include('block.maps')
    <h3>IT Service Grup S.R.L.</h3>
    <p><strong>@lang('contacte.botanica')</strong></p>
    @include('block.contactinfo')
    <p><a href="{{route('locale.rechizite_bancare', session('locale'))}}"
          title="@lang('contacte.rechizite')"><b>@lang('contacte.rechizite')</b></a></p>
    <div class="text_jos">
         <strong>@lang('contacte.grafic')</strong>

        <p>@lang('contacte.desc1')</p>

        <p>@lang('contacte.desc2')</p></div>
@endsection
