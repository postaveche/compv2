<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Act predare {{ $order->order_number }}</title>
@include('admin.service._doc_styles', ['isPdf' => false])
</head><body>
<div class="no-print"><button onclick="window.print()" style="padding:10px 30px;font-size:16px;cursor:pointer;">Tipareste</button></div>
<div class="header">@include('admin.service._doc_header', ['isPdf' => false])</div>

<div class="order-number">ACT DE PREDARE Nr. {{ $order->order_number }}<br>
<small>Data predare: {{ $order->delivered_at ? $order->delivered_at->format('d.m.Y H:i') : now()->format('d.m.Y H:i') }}</small></div>

<div class="section-title">CLIENT</div>
<table><tbody>
<tr><th>Nume</th><td>{{ $order->client->name }}</td></tr>
<tr><th>Telefon</th><td>{{ $order->client->phone }}</td></tr>
@if($order->client->type == 'juridica' && $order->client->company)
<tr><th>Companie</th><td>{{ $order->client->company }}</td></tr>
@endif
</tbody></table>

<div class="section-title">DISPOZITIV PREDAT</div>
<table><tbody>
<tr><th>Tip / Brand / Model</th><td>{{ $order->device_type }} {{ $order->device_brand }} {{ $order->device_model }}</td></tr>
@if($order->serial_number)<tr><th>Serie (S/N)</th><td>{{ $order->serial_number }}</td></tr>@endif
@if($order->accessories)<tr><th>Accesorii restituite</th><td>{{ $order->accessories }}</td></tr>@endif
</tbody></table>

@include('admin.service._doc_return_info')

<div class="section-title">REPARATIE EFECTUATA</div>
<table><tbody>
<tr><th>Problema initiala</th><td>{{ $order->problem_description }}</td></tr>
@if($order->work_done)<tr><th>Lucrari efectuate</th><td>{{ $order->work_done }}</td></tr>@endif
@if($order->parts_used)<tr><th>Piese inlocuite</th><td>{{ $order->parts_used }}</td></tr>@endif
</tbody></table>

<div class="section-title">PLATA</div>
<table><tbody>
<tr><th>Suma achitata</th><td><strong>{{ $order->final_price ? number_format($order->final_price, 0).' MDL' : '-' }}</strong></td></tr>
@if($order->advance_payment > 0)
<tr><th>Avans achitat</th><td>{{ number_format($order->advance_payment, 0) }} MDL</td></tr>
<tr><th>Rest de plata</th><td>{{ number_format($order->final_price - $order->advance_payment, 0) }} MDL</td></tr>
@endif
<tr><th>Garantie</th><td>{{ $order->warranty ? $order->warranty_days.' zile de la '.($order->completed_at ? $order->completed_at->format('d.m.Y') : now()->format('d.m.Y')) : 'Fara garantie' }}</td></tr>
</tbody></table>

<div class="terms">
<strong>Conditii de predare:</strong><br>
1. Clientul confirma primirea dispozitivului in stare functionala conform lucrarilor descrise.<br>
2. Garantia acopera exclusiv lucrarile si piesele mentionate mai sus.<br>
3. Garantia nu acopera defectiuni cauzate de utilizare necorespunzatoare, lichide, supratensiune sau interventii neautorizate.<br>
4. Reclamatiile se accepta in termen de 24 ore de la predare pentru defecte vizibile.
</div>

<table class="sig-table"><tr>
<td>Prestator (Comp.MD)</td>
<td>Client ({{ $order->client->name }})</td>
</tr></table>
</body></html>
