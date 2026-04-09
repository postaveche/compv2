<!DOCTYPE html>
<html><head><meta charset="utf-8"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Lucrari {{ $order->order_number }}</title>
@include('admin.service._doc_styles', ['isPdf' => true])
</head><body>
<div class="header">@include('admin.service._doc_header', ['isPdf' => true])</div>

<div class="order-number">ACT LUCRARI INDEPLINITE Nr. {{ $order->order_number }}<br>
<small>Data: {{ $order->completed_at ? $order->completed_at->format('d.m.Y') : now()->format('d.m.Y') }}</small></div>

<div class="section-title">CLIENT</div>
<table><tbody>
<tr><th>Nume</th><td>{{ $order->client->name }}</td></tr>
<tr><th>Telefon</th><td>{{ $order->client->phone }}</td></tr>
@if($order->client->type == 'juridica' && $order->client->company)
<tr><th>Companie</th><td>{{ $order->client->company }}</td></tr>
@if($order->client->idno)<tr><th>IDNO</th><td>{{ $order->client->idno }}</td></tr>@endif
@endif
</tbody></table>

<div class="section-title">DISPOZITIV</div>
<table><tbody>
<tr><th>Tip</th><td>{{ $order->device_type }}</td></tr>
@if($order->device_brand || $order->device_model)<tr><th>Brand / Model</th><td>{{ $order->device_brand }} {{ $order->device_model }}</td></tr>@endif
@if($order->serial_number)<tr><th>Serie (S/N)</th><td>{{ $order->serial_number }}</td></tr>@endif
</tbody></table>

@include('admin.service._doc_return_info')

<div class="section-title">DEFECTIUNE CONSTATATA</div>
<table><tbody>
<tr><th>Problema raportata</th><td>{{ $order->problem_description }}</td></tr>
@if($order->diagnosis)<tr><th>Diagnostic</th><td>{{ $order->diagnosis }}</td></tr>@endif
</tbody></table>

@if($order->work_done)
<div class="section-title">LUCRARI EFECTUATE</div>
<table><tbody><tr><td>{{ $order->work_done }}</td></tr></tbody></table>
@endif

@if($order->parts_used)
<div class="section-title">PIESE UTILIZATE</div>
<table><tbody><tr><td>{{ $order->parts_used }}</td></tr></tbody></table>
@endif

<div class="section-title">COST SI GARANTIE</div>
<table><tbody>
<tr><th>Cost lucrari</th><td><strong>{{ $order->final_price ? number_format($order->final_price, 0).' MDL' : '-' }}</strong></td></tr>
@if($order->advance_payment > 0)
<tr><th>Avans achitat</th><td>{{ number_format($order->advance_payment, 0) }} MDL</td></tr>
<tr><th>Rest de plata</th><td>{{ number_format($order->final_price - $order->advance_payment, 0) }} MDL</td></tr>
@endif
<tr><th>Achitat</th><td>{{ $order->is_paid ? 'Da' : 'Nu' }}</td></tr>
<tr><th>Garantie</th><td>{{ $order->warranty ? $order->warranty_days.' zile' : 'Fara garantie' }}</td></tr>
<tr><th>Data finalizare</th><td>{{ $order->completed_at ? $order->completed_at->format('d.m.Y H:i') : '-' }}</td></tr>
</tbody></table>

<div class="terms">
Prezentul act confirma efectuarea lucrarilor de reparatie descrise mai sus.
Garantia se aplica exclusiv pentru lucrarile si piesele mentionate in acest document.
</div>

<table class="sig-table"><tr>
<td>Executant (Comp.MD)</td>
<td>Client ({{ $order->client->name }})</td>
</tr></table>
</body></html>
