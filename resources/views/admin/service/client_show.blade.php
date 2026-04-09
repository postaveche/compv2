@extends('admin.layouts.adminlayouts')
@section('title', 'Client: ' . $client->name)
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Client: {{ $client->name }}</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('service.clients.edit', $client->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editeaza</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
<div class="row"><div class="col-md-4">
<div class="card card-info"><div class="card-header"><h3 class="card-title">Date client</h3></div>
<div class="card-body">
<p><span class="badge badge-{{ $client->type == 'juridica' ? 'warning' : 'info' }}">{{ $client->type == 'juridica' ? 'Juridica' : 'Fizica' }}</span></p>
<p><i class="fas fa-phone"></i> {{ $client->phone }} {{ $client->phone2 ? '/ '.$client->phone2 : '' }}</p>
@if($client->email)<p><i class="fas fa-envelope"></i> {{ $client->email }}</p>@endif
@if($client->type == 'juridica')
@if($client->company)<p><i class="fas fa-building"></i> {{ $client->company }}</p>@endif
@if($client->idno)<p><strong>IDNO:</strong> {{ $client->idno }}</p>@endif
@if($client->cod_fiscal)<p><strong>Cod fiscal:</strong> {{ $client->cod_fiscal }}</p>@endif
@if($client->cont_bancar)<p><strong>Cont:</strong> {{ $client->cont_bancar }}</p>@endif
@if($client->banca)<p><strong>Banca:</strong> {{ $client->banca }}</p>@endif
@if($client->adresa_juridica)<p><i class="fas fa-map"></i> {{ $client->adresa_juridica }}</p>@endif
@endif
@if($client->notes)<p><i class="fas fa-sticky-note"></i> {{ $client->notes }}</p>@endif
<p><small>Client din: {{ $client->created_at->format('d.m.Y') }}</small></p>
</div></div></div>
<div class="col-md-8">
<div class="card"><div class="card-header"><h3 class="card-title">Istoric reparatii ({{ $client->orders->count() }})</h3></div>
<div class="card-body p-0">
<table class="table table-striped">
<thead><tr><th>Nr.</th><th>Dispozitiv</th><th>Problema</th><th>Status</th><th>Pret</th><th>Data</th><th></th></tr></thead>
<tbody>
@foreach($client->orders as $order)
@php $colors = ['received'=>'info','diagnosis'=>'warning','waiting_approval'=>'warning','in_repair'=>'primary','waiting_parts'=>'secondary','repaired'=>'success','delivered'=>'dark','returned_unrepaired'=>'danger','cancelled'=>'danger']; @endphp
<tr>
<td>{{ $order->order_number }}</td>
<td>{{ $order->device_type }} {{ $order->device_brand }}</td>
<td><small>{{ Str::limit($order->problem_description, 40) }}</small></td>
<td><span class="badge badge-{{ $colors[$order->status] ?? 'secondary' }}">{{ $order->status_label }}</span></td>
<td>{{ $order->final_price ? number_format($order->final_price,0).' MDL' : '-' }}</td>
<td><small>{{ $order->created_at->format('d.m.Y') }}</small></td>
<td><a href="{{ route('service.show', $order->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
</tr>
@endforeach
</tbody></table></div></div></div></div>
</div></section></div>
@endsection
