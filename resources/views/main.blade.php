@extends('layouts.layouts')

@section('title', __('main.title'))

@section('description', __('main.desc'))

@section('img', \Illuminate\Support\Facades\URL::to('logo.png'))

@section('content')
    <div class="wrapper">
        {{\App\Http\Controllers\MainController::HomeBanners()}}
        <h2>@lang('main.select_product')</h2>
        {{\App\Http\Controllers\MainController::random_main()}}
        <hr/>
        <h2>@lang('main.latest_products')</h2>
        {{\App\Http\Controllers\MainController::last_12()}}
        <hr/>
        <div class="text_jos">
            <p><b>@lang('main.home_q1')</b> @lang('main.home_a1')</p>

            <p><b>@lang('main.home_q2')</b><br>
                @lang('main.home_a2')</p>
        </div>
    </div>
@endsection
