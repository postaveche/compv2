@extends('admin.layouts.adminlayouts')
@section('title', 'Editare ' . $order->order_number)
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Editare: {{ $order->order_number }}</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@include('admin.service._validation_errors')
<form action="{{ route('service.update', $order->id) }}" method="POST">@csrf @method('PUT')
<div class="row">
<div class="col-md-8">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Dispozitiv si problema</h3></div>
<div class="card-body"><div class="row">
<div class="col-md-4"><label>Tip</label><input type="text" name="device_type" class="form-control" value="{{ old('device_type', $order->device_type) }}"></div>
<div class="col-md-4"><label>Brand</label><input type="text" name="device_brand" class="form-control" value="{{ old('device_brand', $order->device_brand) }}"></div>
<div class="col-md-4"><label>Model</label><input type="text" name="device_model" class="form-control" value="{{ old('device_model', $order->device_model) }}"></div>
</div><div class="row mt-2">
<div class="col-md-4"><label>S/N</label><input type="text" name="serial_number" class="form-control" value="{{ old('serial_number', $order->serial_number) }}"></div>
<div class="col-md-4"><label>Accesorii</label><input type="text" name="accessories" class="form-control" value="{{ old('accessories', $order->accessories) }}"></div>
<div class="col-md-4"><label>Stare</label><input type="text" name="device_condition" class="form-control" value="{{ old('device_condition', $order->device_condition) }}"></div>
</div><div class="row mt-2">
<div class="col-12"><label>Problema</label><textarea name="problem_description" class="form-control" rows="2">{{ old('problem_description', $order->problem_description) }}</textarea></div>
</div></div></div>

<div class="card card-warning">
<div class="card-header"><h3 class="card-title">Diagnostic si lucrari</h3></div>
<div class="card-body"><div class="row">
<div class="col-md-6"><label>Diagnostic</label><textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis', $order->diagnosis) }}</textarea></div>
<div class="col-md-6"><label>Lucrari efectuate</label><textarea name="work_done" class="form-control" rows="2">{{ old('work_done', $order->work_done) }}</textarea></div>
</div><div class="row mt-2">
<div class="col-md-6"><label>Piese folosite</label><textarea name="parts_used" class="form-control" rows="2">{{ old('parts_used', $order->parts_used) }}</textarea></div>
<div class="col-md-6"><label>Note interne</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $order->notes) }}</textarea></div>
</div></div></div></div>

<div class="col-md-4">
<div class="card card-success">
<div class="card-header"><h3 class="card-title">Status si pret</h3></div>
<div class="card-body">
<label>Status</label>
<select name="status" class="form-control mb-3">
@foreach($statuses as $key => $label)<option value="{{ $key }}" {{ old('status', $order->status)==$key?'selected':'' }}>{{ $label }}</option>@endforeach
</select>

@if($order->is_return)
<div class="alert alert-warning p-2 mb-3">
<small><strong>RETUR</strong> - Dispozitiv reparat anterior</small>
<div class="mt-1"><input type="checkbox" name="is_warranty_repair" value="1" {{ $order->is_warranty_repair?'checked':'' }}> Reparatie pe garantie</div>
</div>
@endif

<div id="cancel-section" style="{{ in_array(old('status', $order->status), ['returned_unrepaired', 'cancelled']) ? '' : 'display:none;' }}">
<label>Cauza returnare / anulare</label>
<textarea name="cancel_reason" class="form-control mb-3" rows="2">{{ old('cancel_reason', $order->cancel_reason) }}</textarea>
<label>Taxa diagnosticare (MDL)</label>
<input type="number" name="diagnosis_fee" class="form-control mb-3" value="{{ old('diagnosis_fee', $order->diagnosis_fee) }}" step="0.01">
<input type="hidden" name="diagnosis_fee_paid" value="0">
<div class="mb-3"><input type="checkbox" name="diagnosis_fee_paid" value="1" {{ old('diagnosis_fee_paid', $order->diagnosis_fee_paid)?'checked':'' }}> Taxa diagnosticare achitata</div>
</div>

<label>Pret estimat (MDL)</label>
<input type="number" name="estimated_price" class="form-control mb-3" value="{{ old('estimated_price', $order->estimated_price) }}" step="0.01">
<label>Pret final (MDL)</label>
<input type="number" name="final_price" class="form-control mb-3" value="{{ old('final_price', $order->final_price) }}" step="0.01" min="0">
<label>Avans (MDL)</label>
<input type="number" name="advance_payment" class="form-control mb-3" value="{{ old('advance_payment', $order->advance_payment) }}" step="0.01" min="0">
<input type="hidden" name="is_paid" value="0">
<div class="mb-3"><input type="checkbox" name="is_paid" value="1" {{ old('is_paid', $order->is_paid)?'checked':'' }}> Achitat</div>
@include('admin.service._payment_fields')
<div class="mb-3"><input type="checkbox" name="warranty" value="1" {{ $order->warranty?'checked':'' }}> Garantie</div>
<label>Zile garantie</label>
<input type="number" name="warranty_days" class="form-control mb-3" value="{{ old('warranty_days', $order->warranty_days) }}">
<label>Data estimata finalizare</label>
<input type="date" name="estimated_completion" class="form-control mb-3" value="{{ $order->estimated_completion ? $order->estimated_completion->format('Y-m-d') : '' }}">
</div></div>
<button type="submit" class="btn btn-primary btn-block btn-lg mb-2"><i class="fas fa-save"></i> Salveaza</button>
<a href="{{ route('service.show', $order->id) }}" class="btn btn-secondary btn-block">Anuleaza</a>
</div></div>
</form></div></section></div>
<script>
document.querySelector('[name="status"]').addEventListener('change', function() {
    document.getElementById('cancel-section').style.display = (this.value === 'returned_unrepaired' || this.value === 'cancelled') ? '' : 'none';
});
</script>
@endsection
