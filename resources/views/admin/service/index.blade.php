@extends('admin.layouts.adminlayouts')
@section('title', 'Service Center')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Service Center</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('service.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> <span class="d-none d-md-inline">Comanda noua</span></a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card mb-3"><div class="card-body">
<form method="GET" class="row">
<div class="col-6 col-md-4 mb-2"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cauta..." value="{{ request('search') }}"></div>
<div class="col-6 col-md-3 mb-2"><select name="status" class="form-control form-control-sm"><option value="">Toate statusurile</option>
@foreach($statuses as $key => $label)<option value="{{ $key }}" {{ request('status')==$key?'selected':'' }}>{{ $label }}</option>@endforeach
</select></div>
<div class="col-6 col-md-2 mb-2"><button class="btn btn-primary btn-sm btn-block">Cauta</button></div>
<div class="col-6 col-md-2 mb-2"><a href="{{ route('service.index') }}" class="btn btn-secondary btn-sm btn-block">Reset</a></div>
</form></div></div>

<!-- Desktop table -->
<div class="card d-none d-md-block"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-striped table-hover mb-0">
<thead><tr><th>Nr.</th><th>Client</th><th>Dispozitiv</th><th>Status</th><th>Pret</th><th>Data</th><th>Actiuni</th></tr></thead>
<tbody>
@php $colors = ['received'=>'info','diagnosis'=>'warning','waiting_approval'=>'warning','in_repair'=>'primary','waiting_parts'=>'secondary','repaired'=>'success','delivered'=>'dark','returned_unrepaired'=>'danger','cancelled'=>'danger']; @endphp
@foreach($orders as $order)
<tr>
<td><strong>{{ $order->order_number }}</strong></td>
<td><a href="{{ route('service.clients.show', $order->client_id) }}">{{ $order->client->name }}</a><br><small>{{ $order->client->phone }}</small></td>
<td>{{ $order->device_type }}<br><small>{{ $order->device_brand }} {{ $order->device_model }}</small></td>
<td><span class="badge badge-{{ $colors[$order->status] ?? 'secondary' }}">{{ $order->status_label }}</span>
@if($order->is_paid)<br><span class="badge badge-success mt-1">Achitat</span>@endif</td>
<td>{{ $order->final_price ? number_format($order->final_price,0).' MDL' : ($order->estimated_price ? '~'.number_format($order->estimated_price,0) : '-') }}</td>
<td><small>{{ $order->created_at->format('d.m.Y') }}</small></td>
<td>
<a href="{{ route('service.show', $order->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
<a href="{{ route('service.edit', $order->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
<a href="{{ route('service.pdf', $order->id) }}" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i></a>
</td>
</tr>
@endforeach
</tbody></table></div></div></div>

<!-- Mobile cards -->
<div class="d-md-none">
@php $colors = ['received'=>'info','diagnosis'=>'warning','waiting_approval'=>'warning','in_repair'=>'primary','waiting_parts'=>'secondary','repaired'=>'success','delivered'=>'dark','returned_unrepaired'=>'danger','cancelled'=>'danger']; @endphp
@foreach($orders as $order)
<div class="card mb-2">
<div class="card-body p-3">
<div class="d-flex justify-content-between align-items-start mb-2">
<div>
<strong>{{ $order->order_number }}</strong><br>
<small class="text-muted">{{ $order->created_at->format('d.m.Y') }}</small>
</div>
<div class="text-right">
<span class="badge badge-{{ $colors[$order->status] ?? 'secondary' }}">{{ $order->status_label }}</span>
@if($order->is_paid)<br><span class="badge badge-success mt-1">Achitat</span>@endif
</div>
</div>
<div class="mb-2">
<i class="fas fa-user"></i> <a href="{{ route('service.clients.show', $order->client_id) }}">{{ $order->client->name }}</a> - {{ $order->client->phone }}<br>
<i class="fas fa-laptop"></i> {{ $order->device_type }} {{ $order->device_brand }} {{ $order->device_model }}
</div>
@if($order->final_price || $order->estimated_price)
<div class="mb-2">
<i class="fas fa-money-bill"></i> {{ $order->final_price ? number_format($order->final_price,0).' MDL' : '~'.number_format($order->estimated_price,0).' MDL' }}
</div>
@endif
<div class="btn-group btn-group-sm">
<a href="{{ route('service.show', $order->id) }}" class="btn btn-info"><i class="fas fa-eye"></i> Detalii</a>
<a href="{{ route('service.edit', $order->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
<a href="{{ route('service.pdf', $order->id) }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i></a>
</div>
</div></div>
@endforeach
</div>

<div class="d-flex justify-content-center mt-3">{{ $orders->appends(request()->query())->links("pagination::bootstrap-4") }}</div>
</div></section></div>
@endsection
