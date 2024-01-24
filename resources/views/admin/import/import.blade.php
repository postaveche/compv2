@extends('admin.layouts.adminlayouts')

@section('title', 'Import ')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Importarea produselor B2B:</h1>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
    <div>
        <p>{{$cod}}</p>
        <p>{{$product_code}}</p>
        <p>{{$product_sku}}</p>
        <p>{{$product_full_name}}</p>
        <p>{{$product_name_ru}}</p>
        <p>{{$product_name_ro}}</p>
    </div>
        </section>
    </div>
@endsection
