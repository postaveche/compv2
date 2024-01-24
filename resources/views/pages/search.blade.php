@extends('layouts.layouts')

@section('title', __('search.results'). '' .$query)

@section('content')
    <div class="wrapper">
        @if($products->isNotEmpty())
            <h1>@lang('search.results') {{ $query }}</h1>
            <small>@lang('search.total_products') {{ $products_count }}</small>
            @include('block.product_list')
        @else
            <div align="center">
                <img style="max-width: 100%;" src="/img/cat1.jpg" alt="Oops...">
                <h2>@lang('search.no_results')</h2>
            </div>
        @endif
{{--        <div class="d-flex justify-content-center" style="padding-top: 10px;">
            {{ $products->links("pagination::bootstrap-4") }}
        </div>--}}
    </div>
@endsection
