@extends('admin.layouts.adminlayouts')
@section('title', $client ? 'Editare client' : 'Client nou')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>{{ $client ? 'Editare: '.$client->name : 'Client nou' }}</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@include('admin.service._validation_errors')
<div class="card card-primary">
<form action="{{ $client ? route('service.clients.update', $client->id) : route('service.clients.store') }}" method="POST">
@csrf
@if($client) @method('PUT') @endif
<div class="card-body">

@include('admin.service._client_fields')

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
