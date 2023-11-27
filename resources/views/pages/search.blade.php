@extends('layouts.layouts')

@section('title', 'Rezultatul căutării:' .$query)

@section('content')
    <div class="wrapper">
        @if($products->isNotEmpty())
            <h1>Rezultatul căutării: {{ $query }}</h1>
            <small>Produse găsite: {{ $products_count }}</small>
            @include('block.product_list')
        @else
            <div align="center">
                <img style="max-width: 100%;" src="/img/cat1.jpg" alt="Oops...">
                <h2>Nu a fost găsit nimic!!!</h2>
            </div>
        @endif
{{--        <div class="d-flex justify-content-center" style="padding-top: 10px;">
            {{ $products->links("pagination::bootstrap-4") }}
        </div>--}}
    </div>
@endsection
