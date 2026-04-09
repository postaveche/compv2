@extends('admin.layouts.adminlayouts')
@section('title', 'Tipuri dispozitive')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Tipuri de dispozitive</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="row">
<div class="col-md-5">
<div class="card card-success">
<div class="card-header"><h3 class="card-title">Adauga tip nou</h3></div>
<form action="{{ route('service.device-types.store') }}" method="POST">@csrf
<div class="card-body"><div class="row">
<div class="col-8"><input type="text" name="name" class="form-control" placeholder="Ex: Laptop, Imprimanta..." required></div>
<div class="col-4"><input type="number" name="sort_order" class="form-control" placeholder="Ordine" value="0"></div>
</div></div>
<div class="card-footer"><button type="submit" class="btn btn-success">Adauga</button></div>
</form></div></div>
<div class="col-md-7">
<div class="card">
<div class="card-header"><h3 class="card-title">Tipuri existente ({{ $types->count() }})</h3></div>
<div class="card-body p-0">
<table class="table table-striped">
<thead><tr><th>ID</th><th>Denumire</th><th>Ordine</th><th></th></tr></thead>
<tbody>
@foreach($types as $type)
<tr>
<td>{{ $type->id }}</td>
<td>{{ $type->name }}</td>
<td>{{ $type->sort_order }}</td>
<td><form action="{{ route('service.device-types.delete', $type->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form></td>
</tr>
@endforeach
</tbody></table></div></div></div>
</div></div></section></div>
@endsection
