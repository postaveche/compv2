@extends('admin.layouts.adminlayouts')
@section('title', 'Roluri utilizatori')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Roluri / Grupe utilizatori</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="row">
<div class="col-md-5">
<div class="card card-success">
<div class="card-header"><h3 class="card-title">Adauga rol nou</h3></div>
<form action="{{ route('admin.roles.store') }}" method="POST">@csrf
<div class="card-body">
<label>Denumire rol</label>
<input type="text" name="name" class="form-control" placeholder="Ex: Contabil, Operator..." required>
</div>
<div class="card-footer"><button type="submit" class="btn btn-success">Adauga</button></div>
</form></div></div>
<div class="col-md-7">
<div class="card">
<div class="card-header"><h3 class="card-title">Roluri existente</h3></div>
<div class="card-body p-0">
<table class="table table-striped">
<thead><tr><th>ID</th><th>Denumire</th><th>Slug</th><th>Utilizatori</th><th></th></tr></thead>
<tbody>
@foreach($roles as $role)
<tr>
<td>{{ $role->id }}</td>
<td><strong>{{ $role->name }}</strong></td>
<td><code>{{ $role->slug }}</code></td>
<td><span class="badge badge-info">{{ $role->users_count }}</span></td>
<td>
@if($role->id > 4)
<form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi rolul?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
@else
<small class="text-muted">Rol de baza</small>
@endif
</td>
</tr>
@endforeach
</tbody></table></div></div></div>
</div></div></section></div>
@endsection
