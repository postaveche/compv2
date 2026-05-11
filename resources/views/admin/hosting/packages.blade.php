@extends('admin.layouts.adminlayouts')
@section('title', 'Pachete hosting')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Pachete hosting</h1></div>
<div class="col-sm-6 text-right"><a href="{{ route('hosting.index') }}" class="btn btn-secondary">Servicii clienti</a></div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="card mb-3"><div class="card-header"><h3 class="card-title">Adauga pachet</h3></div>
<form action="{{ route('hosting.packages.store') }}" method="POST">@csrf
<div class="card-body"><div class="row">
<div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Nume pachet" required></div>
<div class="col-md-1"><input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="Pret" required></div>
<div class="col-md-1"><select name="currency" class="form-control">@foreach(['EUR','USD','MDL'] as $currency)<option value="{{ $currency }}">{{ $currency }}</option>@endforeach</select></div>
<div class="col-md-2"><select name="period" class="form-control" required><option value="lunar">Lunar</option><option value="anual" selected>Anual</option></select></div>
<div class="col-md-4"><input type="text" name="description" class="form-control" placeholder="Descriere"></div>
<div class="col-md-1"><button class="btn btn-primary btn-block"><i class="fas fa-plus"></i></button></div>
</div></div>
</form></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Nume</th><th style="width: 180px;">Pret</th><th style="width: 130px;">Perioada</th><th>Descriere</th><th style="width: 70px;">Activ</th><th style="width: 100px;">Actiuni</th></tr></thead>
<tbody>
@foreach($packages as $package)
<tr>
<form action="{{ route('hosting.packages.update', $package->id) }}" method="POST">
@csrf @method('PUT')
<td><input type="text" name="name" class="form-control" value="{{ $package->name }}" required></td>
<td><div class="input-group"><input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ $package->price }}" required><div class="input-group-append"><select name="currency" class="form-control">@foreach(['EUR','USD','MDL'] as $currency)<option value="{{ $currency }}" {{ $package->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>@endforeach</select></div></div></td>
<td><select name="period" class="form-control" required><option value="lunar" {{ $package->period == 'lunar' ? 'selected' : '' }}>Lunar</option><option value="anual" {{ $package->period == 'anual' ? 'selected' : '' }}>Anual</option></select></td>
<td><input type="text" name="description" class="form-control" value="{{ $package->description }}"></td>
<td><div class="custom-control custom-checkbox"><input type="checkbox" name="active" class="custom-control-input" id="active_{{ $package->id }}" {{ $package->active ? 'checked' : '' }}><label class="custom-control-label" for="active_{{ $package->id }}"></label></div></td>
<td><button class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
</form>
<form action="{{ route('hosting.packages.delete', $package->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi pachetul?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
</td>
</tr>
@endforeach
</tbody></table>
</div></div></div>
</div></section></div>
@endsection
