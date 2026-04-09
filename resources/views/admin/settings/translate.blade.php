@extends('admin.layouts.adminlayouts')
@section('title', 'Setari Traducere DeepL')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Setari Traducere DeepL</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="row">
<div class="col-md-7">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Configurare DeepL API</h3></div>
<form action="{{ route('admin.translate.settings.update') }}" method="POST">@csrf @method('PUT')
<div class="card-body">
<div class="custom-control custom-switch mb-3">
<input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $settings->active ? 'checked' : '' }}>
<label class="custom-control-label" for="active"><strong>Traducere activa</strong></label>
</div>
<div class="form-group">
<label>DeepL API Key</label>
<input type="text" name="deepl_api_key" class="form-control" value="{{ $settings->deepl_api_key }}" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx:fx">
<small class="text-muted">Obtine cheia de la <a href="https://www.deepl.com/pro-api" target="_blank">deepl.com/pro-api</a> (Free = 500.000 car/luna)</small>
</div>
</div>
<div class="card-footer">
<button type="submit" class="btn btn-primary">Salveaza</button>
<a href="{{ route('admin.translate.test') }}" class="btn btn-success"><i class="fas fa-flask"></i> Test traducere</a>
</div>
</form></div></div>
<div class="col-md-5">
<div class="card card-info">
<div class="card-header"><h3 class="card-title">Instructiuni</h3></div>
<div class="card-body" style="font-size:13px;">
<p><strong>1.</strong> Mergi la <a href="https://www.deepl.com/pro-api" target="_blank">deepl.com/pro-api</a></p>
<p><strong>2.</strong> Creaza cont gratuit (DeepL API Free)</p>
<p><strong>3.</strong> Copiaza cheia API din cont</p>
<p><strong>4.</strong> Lipeste cheia aici si activeaza</p>
<p><strong>5.</strong> Apasa "Test traducere" pentru verificare</p>
<hr>
<p><small>Planul gratuit ofera 500.000 caractere/luna. Cheia Free se termina cu <code>:fx</code></small></p>
</div></div></div>
</div></div></section></div>
@endsection
