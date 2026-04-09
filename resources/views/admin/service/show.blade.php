@extends('admin.layouts.adminlayouts')
@section('title', 'Comanda ' . $order->order_number)
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Comanda: {{ $order->order_number }}</h1></div>
<div class="col-sm-6 text-right">
<a href="{{ route('service.edit', $order->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editeaza</a>
<div class="btn-group">
<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-print"></i> Documente</button>
<div class="dropdown-menu dropdown-menu-right">
<h6 class="dropdown-header">Act primire</h6>
<a class="dropdown-item" href="{{ route('service.print', $order->id) }}" target="_blank"><i class="fas fa-print"></i> Tipareste</a>
<a class="dropdown-item" href="{{ route('service.pdf', $order->id) }}"><i class="fas fa-file-pdf"></i> Descarca PDF</a>
<div class="dropdown-divider"></div>
<h6 class="dropdown-header">Act predare (la ridicare)</h6>
<a class="dropdown-item" href="{{ route('service.delivery', $order->id) }}" target="_blank"><i class="fas fa-print"></i> Tipareste</a>
<a class="dropdown-item" href="{{ route('service.delivery.pdf', $order->id) }}"><i class="fas fa-file-pdf"></i> Descarca PDF</a>
<div class="dropdown-divider"></div>
<h6 class="dropdown-header">Act lucrari indeplinite</h6>
<a class="dropdown-item" href="{{ route('service.work-report', $order->id) }}" target="_blank"><i class="fas fa-print"></i> Tipareste</a>
<a class="dropdown-item" href="{{ route('service.work-report.pdf', $order->id) }}"><i class="fas fa-file-pdf"></i> Descarca PDF</a>
</div>
</div>
<a href="{{ route('service.index') }}" class="btn btn-default">Inapoi</a>
</div></div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@php $colors = ['received'=>'info','diagnosis'=>'warning','waiting_approval'=>'warning','in_repair'=>'primary','waiting_parts'=>'secondary','repaired'=>'success','delivered'=>'dark','returned_unrepaired'=>'danger','cancelled'=>'danger']; @endphp
<div class="row">
<div class="col-md-8">
<div class="card">
<div class="card-header"><h3 class="card-title">Detalii dispozitiv</h3>
<span class="float-right badge badge-{{ $colors[$order->status] ?? 'secondary' }} p-2">{{ $order->status_label }}</span></div>
<div class="card-body">
<table class="table"><tbody>
<tr><th style="width:200px">Tip</th><td>{{ $order->device_type }}
@if($order->is_return) <span class="badge badge-warning">RETUR</span> @endif
@if($order->is_warranty_repair) <span class="badge badge-info">GARANTIE</span> @endif
</td></tr>
<tr><th>Brand / Model</th><td>{{ $order->device_brand }} {{ $order->device_model }}</td></tr>
<tr><th>Serie (S/N)</th><td>{{ $order->serial_number ?? '-' }}</td></tr>
<tr><th>Accesorii</th><td>{{ $order->accessories ?? '-' }}</td></tr>
<tr><th>Stare la primire</th><td>{{ $order->device_condition ?? '-' }}</td></tr>
<tr><th>Problema</th><td>{{ $order->problem_description }}</td></tr>
<tr><th>Diagnostic</th><td>{{ $order->diagnosis ?? '-' }}</td></tr>
<tr><th>Lucrari efectuate</th><td>{{ $order->work_done ?? '-' }}</td></tr>
<tr><th>Piese folosite</th><td>{{ $order->parts_used ?? '-' }}</td></tr>
<tr><th>Pret estimat</th><td>{{ $order->estimated_price ? number_format($order->estimated_price,0).' MDL' : '-' }}</td></tr>
<tr><th>Pret final</th><td><strong>{{ $order->final_price ? number_format($order->final_price,0).' MDL' : '-' }}</strong></td></tr>
<tr><th>Avans achitat</th><td>{{ $order->advance_payment > 0 ? number_format($order->advance_payment,0).' MDL' : '-' }}
@if($order->advance_payment > 0 && $order->final_price)
<br><small class="text-muted">Rest de plata: {{ number_format($order->final_price - $order->advance_payment, 0) }} MDL</small>
@endif
</td></tr>
<tr><th>Achitat integral</th><td>{!! $order->is_paid ? '<span class="badge badge-success">Da</span>' : '<span class="badge badge-danger">Nu</span>' !!}</td></tr>
@if($order->cancel_reason)
<tr><th>Cauza returnare/anulare</th><td>{{ $order->cancel_reason }}</td></tr>
@endif
@if($order->diagnosis_fee > 0)
<tr><th>Taxa diagnosticare</th><td>{{ number_format($order->diagnosis_fee, 0) }} MDL {!! $order->diagnosis_fee_paid ? '<span class="badge badge-success">Achitata</span>' : '<span class="badge badge-danger">Neachitata</span>' !!}</td></tr>
@endif
<tr><th>Garantie</th><td>{{ $order->warranty ? $order->warranty_days.' zile' : 'Nu' }}</td></tr>
<tr><th>Data estimata</th><td>{{ $order->estimated_completion ? $order->estimated_completion->format('d.m.Y') : '-' }}</td></tr>
<tr><th>Finalizat</th><td>{{ $order->completed_at ? $order->completed_at->format('d.m.Y H:i') : '-' }}</td></tr>
<tr><th>Predat</th><td>{{ $order->delivered_at ? $order->delivered_at->format('d.m.Y H:i') : '-' }}</td></tr>
<tr><th>Note</th><td>{{ $order->notes ?? '-' }}</td></tr>
@if($order->is_return && $order->parentOrder)
<tr><th>Comanda anterioara</th><td><a href="{{ route('service.show', $order->parent_order_id) }}">{{ $order->parentOrder->order_number }}</a> ({{ $order->parentOrder->created_at->format('d.m.Y') }})</td></tr>
@endif
@if($order->returnOrders->count() > 0)
<tr><th>Retururi ulterioare</th><td>
@foreach($order->returnOrders as $ret)
<a href="{{ route('service.show', $ret->id) }}">{{ $ret->order_number }}</a> ({{ $ret->created_at->format('d.m.Y') }}){{ !$loop->last ? ', ' : '' }}
@endforeach
</td></tr>
@endif
</tbody></table></div></div></div>
<div class="col-md-4">
<div class="card card-info">
<div class="card-header"><h3 class="card-title">Client</h3></div>
<div class="card-body">
<p><strong>{{ $order->client->name }}</strong></p>
<p><span class="badge badge-{{ $order->client->type == 'juridica' ? 'warning' : 'info' }}">{{ $order->client->type == 'juridica' ? 'Juridica' : 'Fizica' }}</span></p>
<p><i class="fas fa-phone"></i> {{ $order->client->phone }} {{ $order->client->phone2 ? '/ '.$order->client->phone2 : '' }}</p>
@if($order->client->email)<p><i class="fas fa-envelope"></i> {{ $order->client->email }}</p>@endif
@if($order->client->type == 'juridica')
@if($order->client->company)<p><i class="fas fa-building"></i> {{ $order->client->company }}</p>@endif
@if($order->client->idno)<p><strong>IDNO:</strong> {{ $order->client->idno }}</p>@endif
@endif
<a href="{{ route('service.clients.show', $order->client_id) }}" class="btn btn-sm btn-info btn-block">Istoric client</a>
</div></div>

<!-- Poze dispozitiv -->
<div class="card card-secondary">
<div class="card-header"><h3 class="card-title">Poze dispozitiv ({{ $order->photos->count() }})</h3></div>
<div class="card-body">
@if($order->photos->count() > 0)
<div class="row">
@foreach($order->photos as $photo)
<div class="col-4 mb-2 text-center">
<a href="{{ asset('storage/service/' . $photo->image) }}" target="_blank">
<img src="{{ asset('storage/service/' . $photo->image) }}" class="img-thumbnail" style="max-height:120px;object-fit:cover;">
</a>
<br><small class="text-muted">{{ ucfirst($photo->stage) }}</small>
<form action="{{ route('service.photos.delete', $photo->id) }}" method="POST" onsubmit="return confirm('Stergi poza?')">@csrf @method('DELETE')
<button class="btn btn-xs btn-danger mt-1"><i class="fas fa-trash"></i></button></form>
</div>
@endforeach
</div>
@else
<p class="text-muted text-center">Fara poze</p>
@endif
<hr>
<form action="{{ route('service.photos.add', $order->id) }}" method="POST" enctype="multipart/form-data">@csrf
<div class="form-group">
<label>Adauga poze</label>
<input type="file" name="photos[]" class="form-control-file" multiple accept="image/*">
<select name="stage" class="form-control mt-2">
<option value="received">La primire</option>
<option value="diagnosis">Diagnostic</option>
<option value="repaired">Dupa reparatie</option>
</select>
</div>
<button type="submit" class="btn btn-sm btn-success btn-block">Incarca poze</button>
</form>
</div></div>
<div class="card"><div class="card-body">
<p><small>Primit de: {{ $order->receivedBy->name ?? 'N/A' }}</small></p>
<p><small>Creat: {{ $order->created_at->format('d.m.Y H:i') }}</small></p>
<p><small>Actualizat: {{ $order->updated_at->format('d.m.Y H:i') }}</small></p>
</div></div></div>
</div></div></section></div>
@endsection
