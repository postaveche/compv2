@extends('admin.layouts.adminlayouts')
@section('title', 'Utilizatori')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Utilizatori</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Utilizator nou</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card mb-3"><div class="card-body">
<form method="GET" class="row">
<div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Cauta: nume, email..." value="{{ request('search') }}"></div>
<div class="col-md-3"><select name="role_id" class="form-control"><option value="">Toate rolurile</option>
@foreach($roles as $role)<option value="{{ $role->id }}" {{ request('role_id')==$role->id?'selected':'' }}>{{ $role->name }}</option>@endforeach
</select></div>
<div class="col-md-2"><button class="btn btn-primary btn-block">Cauta</button></div>
<div class="col-md-2"><a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-block">Reset</a></div>
</form></div></div>
<div class="card"><div class="card-body p-0">
<table class="table table-striped">
<thead><tr><th>ID</th><th>Nume</th><th>Email</th><th>Rol</th><th>Inregistrat</th><th>Actiuni</th></tr></thead>
<tbody>
@foreach($users as $user)
<tr>
<td>{{ $user->id }}</td>
<td><strong>{{ $user->name }}</strong></td>
<td>{{ $user->email }}</td>
<td><span class="badge badge-{{ $user->role_id==1?'danger':($user->role_id==2?'warning':($user->role_id==3?'info':'secondary')) }}">{{ $rolesMap[$user->role_id] ?? 'N/A' }}</span></td>
<td><small>{{ $user->created_at->format('d.m.Y') }}</small></td>
<td>
<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@if($user->id != auth()->id())
<form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi utilizatorul?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
@endif
</td>
</tr>
@endforeach
</tbody></table></div></div>
<div class="d-flex justify-content-center">{{ $users->appends(request()->query())->links("pagination::bootstrap-4") }}</div>
</div></section></div>
@endsection
