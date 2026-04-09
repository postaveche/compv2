@extends('admin.layouts.adminlayouts')
@section('title', 'Clienti Service')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Clienti Service</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('service.clients.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Client nou</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card mb-3"><div class="card-body">
<form method="GET" class="row">
<div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cauta: nume, telefon, email..." value="{{ request('search') }}"></div>
<div class="col-md-2"><button class="btn btn-primary btn-block">Cauta</button></div>
</form></div></div>
<div class="card"><div class="card-body p-0">
<table class="table table-striped">
<thead><tr><th>ID</th><th>Tip</th><th>Nume</th><th>Telefon</th><th>Email</th><th>Companie</th><th>Comenzi</th><th>Actiuni</th></tr></thead>
<tbody>
@foreach($clients as $client)
<tr>
<td>{{ $client->id }}</td>
<td><span class="badge badge-{{ $client->type == 'juridica' ? 'warning' : 'info' }}">{{ $client->type == 'juridica' ? 'Jur.' : 'Fiz.' }}</span></td>
<td><strong>{{ $client->name }}</strong>@if($client->company)<br><small>{{ $client->company }}</small>@endif</td>
<td>{{ $client->phone }}</td>
<td>{{ $client->email ?? '-' }}</td>
<td>{{ $client->company ?? '-' }}</td>
<td><span class="badge badge-info">{{ $client->orders_count }}</span></td>
<td>
<a href="{{ route('service.clients.show', $client->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
<a href="{{ route('service.clients.edit', $client->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
</td>
</tr>
@endforeach
</tbody></table></div></div>
<div class="d-flex justify-content-center">{{ $clients->appends(request()->query())->links("pagination::bootstrap-4") }}</div>
</div></section></div>
@endsection
