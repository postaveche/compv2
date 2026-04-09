@extends('admin.layouts.adminlayouts')
@section('title', $client ? 'Editare client' : 'Client nou')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>{{ $client ? 'Editare: '.$client->name : 'Client nou' }}</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card card-primary">
<form action="{{ $client ? route('service.clients.update', $client->id) : route('service.clients.store') }}" method="POST">
@csrf
@if($client) @method('PUT') @endif
<div class="card-body">

<div class="row mb-3">
<div class="col-md-4">
<label>Tip client *</label>
<select name="type" id="client-type" class="form-control" required>
<option value="fizica" {{ ($client->type ?? 'fizica') == 'fizica' ? 'selected' : '' }}>Persoana fizica</option>
<option value="juridica" {{ ($client->type ?? '') == 'juridica' ? 'selected' : '' }}>Persoana juridica</option>
</select>
</div>
</div>

<div class="row">
<div class="col-md-4"><label>Nume Prenume *</label><input type="text" name="name" class="form-control" value="{{ $client->name ?? '' }}" required placeholder="Ion Popescu"></div>
<div class="col-md-4"><label>Telefon *</label><input type="text" name="phone" class="form-control" value="{{ $client->phone ?? '' }}" required placeholder="+373 XX XXX XXX"></div>
<div class="col-md-4"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $client->email ?? '' }}" placeholder="email@exemplu.md"></div>
</div>

<!-- Campuri juridica -->
<div id="juridica-fields" style="{{ ($client->type ?? 'fizica') == 'juridica' ? '' : 'display:none;' }}">
<hr>
<h5>Rechizite companie</h5>
<div class="row">
<div class="col-md-4"><label>Denumire companie</label><input type="text" name="company" class="form-control" value="{{ $client->company ?? '' }}" placeholder="SRL Exemplu"></div>
<div class="col-md-4"><label>IDNO</label><input type="text" name="idno" class="form-control" value="{{ $client->idno ?? '' }}" placeholder="1234567890123"></div>
<div class="col-md-4"><label>Cod fiscal</label><input type="text" name="cod_fiscal" class="form-control" value="{{ $client->cod_fiscal ?? '' }}"></div>
</div>
<div class="row mt-2">
<div class="col-md-4"><label>Cont bancar</label><input type="text" name="cont_bancar" class="form-control" value="{{ $client->cont_bancar ?? '' }}" placeholder="MD..."></div>
<div class="col-md-4"><label>Banca</label><input type="text" name="banca" class="form-control" value="{{ $client->banca ?? '' }}" placeholder="Maib, Micb..."></div>
<div class="col-md-4"><label>Adresa juridica</label><input type="text" name="adresa_juridica" class="form-control" value="{{ $client->adresa_juridica ?? '' }}"></div>
</div>
</div>

<div class="row mt-3">
<div class="col-md-12"><label>Note</label><input type="text" name="notes" class="form-control" value="{{ $client->notes ?? '' }}" placeholder="Note optionale..."></div>
</div>

</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Salveaza</button> <a href="{{ route('service.clients') }}" class="btn btn-secondary">Anuleaza</a></div>
</form></div>
</div></section></div>
<script>
document.getElementById('client-type').addEventListener('change', function() {
    document.getElementById('juridica-fields').style.display = this.value === 'juridica' ? '' : 'none';
});
</script>
@endsection
