@extends('admin.layouts.adminlayouts')
@section('title', $user ? 'Editare utilizator' : 'Utilizator nou')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>{{ $user ? 'Editare: '.$user->name : 'Utilizator nou' }}</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<div class="card card-primary">
<form action="{{ $user ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
@csrf
@if($user) @method('PUT') @endif
<div class="card-body"><div class="row">
<div class="col-md-6"><label>Nume *</label><input type="text" name="name" class="form-control" value="{{ $user->name ?? old('name') }}" required></div>
<div class="col-md-6"><label>Email *</label><input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}" required></div>
</div><div class="row mt-3">
<div class="col-md-4"><label>Parola {{ $user ? '(gol = nu schimba)' : '*' }}</label><input type="password" name="password" class="form-control" {{ $user ? '' : 'required' }}></div>
<div class="col-md-4"><label>Confirma parola</label><input type="password" name="password_confirmation" class="form-control"></div>
<div class="col-md-4"><label>Rol *</label>
<select name="role_id" class="form-control" required>
@foreach($roles as $role)<option value="{{ $role->id }}" {{ ($user->role_id ?? 4)==$role->id?'selected':'' }}>{{ $role->name }}</option>@endforeach
</select></div>
</div></div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Salveaza</button> <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Anuleaza</a></div>
</form></div>
</div></section></div>
@endsection
