@extends('admin.layouts.adminlayouts')
@section('title', 'Service Produse')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Service Produse</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Inapoi la produse</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')

<div class="row">
<div class="col-md-6">
<div class="card card-danger">
<div class="card-header"><h3 class="card-title"><i class="fas fa-ban"></i> Dezactiveaza produse dupa categorie</h3></div>
<form action="{{ route('products.deactivate-by-category') }}" method="POST" onsubmit="return confirm('Esti sigur? Toate produsele din aceasta categorie si subcategoriile sale vor fi dezactivate!')">
@csrf
<div class="card-body">
<label>Selecteaza categoria:</label>
<select name="category_id" class="form-control" required>
<option value="">Alege categoria</option>
@php
    if (!function_exists('renderServiceCatOpts')) {
        function renderServiceCatOpts($cats, $parentId = '0', $prefix = '') {
            $children = $cats->where('subcat', $parentId)->sortBy('name');
            foreach ($children as $c) {
                $count = \App\Models\Product::where('category_id', $c->id)->where('active', 1)->count();
                echo '<option value="'.$c->id.'">'.$prefix.$c->name.' ('.$count.' active)</option>';
                renderServiceCatOpts($cats, $c->id, $prefix.'— ');
            }
        }
    }
    renderServiceCatOpts($categories);
@endphp
</select>
<small class="text-muted">Se vor dezactiva doar produsele din categoria selectata</small>
</div>
<div class="card-footer"><button type="submit" class="btn btn-danger"><i class="fas fa-ban"></i> Dezactiveaza toate</button></div>
</form></div></div>

<div class="col-md-6">
<div class="card card-success">
<div class="card-header"><h3 class="card-title"><i class="fas fa-check"></i> Activeaza produse dupa categorie</h3></div>
<form action="{{ route('products.activate-by-category') }}" method="POST" onsubmit="return confirm('Esti sigur? Toate produsele din aceasta categorie si subcategoriile sale vor fi activate!')">
@csrf
<div class="card-body">
<label>Selecteaza categoria:</label>
<select name="category_id" class="form-control" required>
<option value="">Alege categoria</option>
@php
    if (!function_exists('renderServiceCatOpts2')) {
        function renderServiceCatOpts2($cats, $parentId = '0', $prefix = '') {
            $children = $cats->where('subcat', $parentId)->sortBy('name');
            foreach ($children as $c) {
                $count = \App\Models\Product::where('category_id', $c->id)->where('active', 0)->count();
                echo '<option value="'.$c->id.'">'.$prefix.$c->name.' ('.$count.' inactive)</option>';
                renderServiceCatOpts2($cats, $c->id, $prefix.'— ');
            }
        }
    }
    renderServiceCatOpts2($categories);
@endphp
</select>
<small class="text-muted">Se vor activa doar produsele din categoria selectata</small>
</div>
<div class="card-footer"><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Activeaza toate</button></div>
</form></div></div>
</div>

</div></section></div>
@endsection
