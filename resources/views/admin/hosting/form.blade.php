@extends('admin.layouts.adminlayouts')
@section('title', $service ? 'Editeaza serviciu' : 'Serviciu nou')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>{{ $service ? 'Editeaza serviciu' : 'Serviciu nou' }}</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('hosting.index') }}" class="btn btn-secondary">Inapoi</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form action="{{ $service ? route('hosting.update', $service->id) : route('hosting.store') }}" method="POST">
@csrf
@if($service) @method('PUT') @endif
<div class="card"><div class="card-body">
<div class="row">
<div class="col-md-4"><div class="form-group"><label>Client</label><div class="input-group"><select name="client_id" class="form-control" required><option value="">Selecteaza client</option>@foreach($clients as $client)<option value="{{ $client->id }}" {{ old('client_id', $service->client_id ?? '') == $client->id ? 'selected' : '' }}>{{ $client->name }} - {{ $client->phone }}</option>@endforeach</select><div class="input-group-append"><a href="{{ route('service.clients.create') }}" class="btn btn-outline-primary" title="Adauga client nou"><i class="fas fa-user-plus"></i></a></div></div></div></div>
<div class="col-md-2"><div class="form-group"><label>Tip</label><select name="type" class="form-control" required>@foreach($types as $key => $label)<option value="{{ $key }}" {{ old('type', $service->type ?? 'hosting') == $key ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div></div>
<div class="col-md-3"><div class="form-group"><label>Pachet hosting</label><select name="hosting_package_id" id="hosting_package_id" class="form-control"><option value="">Fara pachet</option>@foreach($packages as $package)<option value="{{ $package->id }}" data-price="{{ $package->price }}" data-currency="{{ $package->currency }}" {{ old('hosting_package_id', $service->hosting_package_id ?? '') == $package->id ? 'selected' : '' }}>{{ $package->name }} - {{ number_format($package->price, 2) }} {{ $package->currency }}</option>@endforeach</select></div></div>
<div class="col-md-3"><div class="form-group"><label>Nume serviciu</label><input type="text" name="name" class="form-control" value="{{ old('name', $service->name ?? '') }}" required></div></div>
</div>
<div class="row">
<div class="col-md-3"><div class="form-group"><label>Domeniu</label><input type="text" name="domain" class="form-control" value="{{ old('domain', $service->domain ?? '') }}" placeholder="ex: comp.md"></div></div>
<div class="col-md-3"><div class="form-group"><label>Registrar</label><input type="text" name="registrar" class="form-control" value="{{ old('registrar', $service->registrar ?? '') }}"></div></div>
<div class="col-md-3"><div class="form-group"><label>Server / cont hosting</label><input type="text" name="server" class="form-control" value="{{ old('server', $service->server ?? '') }}"></div></div>
<div class="col-md-2"><div class="form-group"><label>Pret</label><input type="number" step="0.01" min="0" name="price" id="price" class="form-control" value="{{ old('price', $service->price ?? '0') }}" required></div></div>
<div class="col-md-1"><div class="form-group"><label>Valuta</label><select name="currency" id="currency" class="form-control">@foreach(['EUR','USD','MDL'] as $currency)<option value="{{ $currency }}" {{ old('currency', $service->currency ?? 'MDL') == $currency ? 'selected' : '' }}>{{ $currency }}</option>@endforeach</select></div></div>
</div>
<div class="row">
<div class="col-md-3"><div class="form-group"><label>Data inceput</label><input type="date" name="started_at" class="form-control" value="{{ old('started_at', optional($service->started_at ?? null)->format('Y-m-d')) }}"></div></div>
<div class="col-md-3"><div class="form-group"><label>Expira la</label><input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', optional($service->expires_at ?? null)->format('Y-m-d')) }}" required></div></div>
<div class="col-md-3"><div class="form-group"><label>De platit pana la</label><input type="date" name="payment_due_at" class="form-control" value="{{ old('payment_due_at', optional($service->payment_due_at ?? null)->format('Y-m-d')) }}" required></div></div>
<div class="col-md-3"><div class="form-group mt-4">
<div class="custom-control custom-checkbox"><input type="checkbox" name="is_paid" class="custom-control-input" id="is_paid" {{ old('is_paid', $service->is_paid ?? false) ? 'checked' : '' }}><label class="custom-control-label" for="is_paid">Achitat</label></div>
@if($service)<small class="text-muted">Activ se calculeaza automat dupa data expirarii.</small>@endif
</div></div>
</div>
<div class="form-group"><label>Note</label><textarea name="notes" class="form-control" rows="4">{{ old('notes', $service->notes ?? '') }}</textarea></div>
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Salveaza</button> <a href="{{ route('hosting.index') }}" class="btn btn-secondary">Anuleaza</a></div>
</div>
</form>
</div></section></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var packageSelect = document.getElementById('hosting_package_id');
    packageSelect.addEventListener('change', function () {
        var option = packageSelect.options[packageSelect.selectedIndex];
        if (option.dataset.price) {
            document.getElementById('price').value = option.dataset.price;
            document.getElementById('currency').value = option.dataset.currency;
        }
    });
});
</script>
@endsection
