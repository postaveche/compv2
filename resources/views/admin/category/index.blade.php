@extends('admin.layouts.adminlayouts')
@section('title', 'Categorii')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Categorii de produse</h1></div>
<div class="col-sm-6 text-right"><a class="btn btn-primary" href="{{ route('category.create') }}"><i class="fas fa-plus"></i> Adauga categorie</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-hover mb-0">
<thead><tr>
<th style="width:1%">ID</th>
<th>Denumirea</th>
<th class="text-center">Status</th>
<th class="d-none d-md-table-cell">B2B Code</th>
<th class="text-right">Actiuni</th>
</tr></thead>
<tbody>
@foreach($categories as $cat)
@php $isMain = $cat->_level == 0; @endphp
<tr style="{{ $isMain ? 'background:#f0f7ff;' : '' }}">
<td>{{ $cat->id }}</td>
<td>
<span style="padding-left:{{ $cat->_level * 25 }}px;">
@if($isMain)
    <strong><i class="fas fa-folder text-primary"></i> {{ $cat->name }}</strong>
@else
    <i class="fas fa-{{ $cat->_level == 1 ? 'folder-open text-info' : 'file text-muted' }}"></i> {{ $cat->name }}
@endif
</span>
</td>
<td class="text-center">
@if($cat->active == 1)
    <span class="badge badge-success">Activ</span>
@else
    <span class="badge badge-danger">Inactiv</span>
@endif
</td>
<td class="d-none d-md-table-cell">{{ $cat->b2b_code ?? '-' }}</td>
<td class="text-right">
@if($cat->b2b_code)
<a class="btn btn-sm btn-secondary" href="/admincp/import/{{$cat->b2b_code}}/{{$cat->id}}"><i class="fas fa-download"></i> <span class="d-none d-md-inline">B2B</span></a>
@endif
<a class="btn btn-sm btn-info" href="{{ route('category.edit', $cat->id) }}"><i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span></a>
<form action="{{ route('category.destroy', $cat->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi categoria?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
</td>
</tr>
@endforeach
</tbody></table></div></div></div>
</div></section></div>
@endsection
