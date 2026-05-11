@extends('admin.layouts.adminlayouts')
@section('title', 'Hosting si domenii')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Hosting si domenii</h1></div>
<div class="col-sm-6 text-right">
<a href="{{ route('hosting.packages') }}" class="btn btn-outline-secondary"><i class="fas fa-box"></i> Pachete</a>
<a href="{{ route('hosting.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Serviciu nou</a>
</div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card mb-3"><div class="card-body">
<form method="GET" class="row">
<div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Cauta client, domeniu, serviciu..." value="{{ request('search') }}"></div>
<div class="col-md-2"><select name="type" class="form-control"><option value="">Toate tipurile</option>@foreach($types as $key => $label)<option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
<div class="col-md-2"><select name="paid" class="form-control"><option value="">Toate platile</option><option value="0" {{ request('paid') === '0' ? 'selected' : '' }}>Neachitate</option><option value="1" {{ request('paid') === '1' ? 'selected' : '' }}>Achitate</option></select></div>
<div class="col-md-2"><button class="btn btn-primary btn-block">Cauta</button></div>
<div class="col-md-2"><a href="{{ route('hosting.index') }}" class="btn btn-secondary btn-block">Reset</a></div>
</form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Tip</th><th>Serviciu</th><th>Client</th><th>Suma</th><th>Cont plata</th><th>Plata</th><th>Expira</th><th>Status</th><th>Actiuni</th></tr></thead>
<tbody>
@forelse($services as $service)
@php $invoice = ($service->latestInvoice && $service->latestInvoice->service_expires_at->isSameDay($service->expires_at)) ? $service->latestInvoice : null; @endphp
<tr class="{{ !$service->is_paid && $service->active && $service->days_until_payment <= 30 ? ($service->days_until_payment < 0 ? 'table-danger' : 'table-warning') : '' }}">
<td><span class="badge badge-{{ $service->type == 'hosting' ? 'primary' : 'info' }}">{{ $service->type_label }}</span></td>
<td><strong>{{ $service->name }}</strong>@if($service->domain)<br><small>{{ $service->domain }}</small>@endif @if($service->package)<br><small>Pachet: {{ $service->package->name }}</small>@endif</td>
<td>{{ $service->client->name }}<br><small>{{ $service->client->phone }}</small></td>
<td>{{ number_format($service->price, 2) }} {{ $service->currency }}</td>
<td>
@if($invoice)
<a href="{{ route('hosting.invoices.show', $invoice->id) }}" target="_blank" class="badge badge-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">{{ $invoice->invoice_number }}</a><br><small>{{ $invoice->issued_at->format('d.m.Y') }}</small>
@elseif($service->expires_at->lte(now()->addDays(30)->startOfDay()))
<form action="{{ route('hosting.invoice.generate', $service->id) }}" method="POST">@csrf<button class="btn btn-xs btn-outline-primary"><i class="fas fa-file-invoice"></i> Genereaza cont</button></form>
@else
<small class="text-muted">Disponibil peste {{ now()->startOfDay()->diffInDays($service->expires_at->copy()->subDays(30)->startOfDay(), false) }} zile</small>
@endif
</td>
<td>{{ $service->payment_due_at->format('d.m.Y') }}<br><small class="{{ !$service->is_paid && $service->days_until_payment <= 30 ? 'font-weight-bold' : '' }}">{{ $service->days_until_payment < 0 ? 'Intarziat: '.abs($service->days_until_payment).' zile' : 'In '.$service->days_until_payment.' zile' }}</small></td>
<td>{{ $service->expires_at->format('d.m.Y') }}</td>
<td><span class="badge badge-{{ $service->status_color }}">{{ $service->is_paid ? 'Achitat' : 'De achitat' }}</span>@if(!$service->active)<br><span class="badge badge-secondary">Inactiv</span>@endif</td>
<td>
<a href="{{ route('hosting.edit', $service->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
@if(!$service->is_paid)
<form action="{{ route('hosting.paid', $service->id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-success" title="Marcheaza achitat"><i class="fas fa-check"></i></button></form>
<form action="{{ route('hosting.reminder', $service->id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-info" title="Trimite Telegram"><i class="fab fa-telegram-plane"></i></button></form>
@endif
<form action="{{ route('hosting.destroy', $service->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi serviciul?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
</td>
</tr>
@empty
<tr><td colspan="9" class="text-center p-4">Nu sunt servicii adaugate.</td></tr>
@endforelse
</tbody></table>
</div></div></div>
<div class="d-flex justify-content-center">{{ $services->appends(request()->query())->links("pagination::bootstrap-4") }}</div>
</div></section></div>
@endsection
