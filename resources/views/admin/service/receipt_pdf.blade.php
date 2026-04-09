<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Act {{ $order->order_number }}</title>
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 10px; color: #333; line-height: 1.3; }
.header { text-align: center; margin-bottom: 8px; padding-bottom: 5px; }
.order-number { font-size: 13px; font-weight: bold; text-align: right; margin-bottom: 8px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
table th, table td { border: 1px solid #999; padding: 3px 5px; text-align: left; }
table th { background: #f0f0f0; width: 160px; }
.section-title { font-weight: bold; font-size: 11px; margin: 8px 0 3px; background: #eee; padding: 3px; }
.terms { font-size: 8px; color: #666; margin-top: 10px; border-top: 1px solid #ccc; padding-top: 5px; }
.sig-table { width: 100%; margin-top: 25px; }
.sig-table td { width: 50%; text-align: center; border: none; padding-top: 25px; border-top: 1px solid #333; font-size: 10px; }
</style></head><body>

<div class="header">
<table style="width:100%;border:none;margin-bottom:10px;border-bottom:2px solid #333;padding-bottom:10px;">
<tr style="border:none;">
<td style="border:none;width:30%;vertical-align:middle;">
@php
    $logoPath = public_path('logo.png');
    $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
@endphp
@if($logoData)
<img src="data:image/png;base64,{{ $logoData }}" style="height: 45px;">
@endif
</td>
<td style="border:none;text-align:right;font-size:11px;color:#555;vertical-align:middle;">
IT Service Grup S.R.L.<br>
str. Sarmizegetusa 51, et. 1, of. 130<br>
mun. Chisinau, Republica Moldova<br>
Tel: 060 229-129, 078 37-37-36, 067 711-444
</td>
</tr>
</table>
</div>

<div class="order-number">ACT DE PRIMIRE-PREDARE Nr. {{ $order->order_number }}<br>
<small>Data: {{ $order->created_at->format('d.m.Y H:i') }}</small></div>

<div class="section-title">DATE CLIENT</div>
<table><tbody>
<tr><th>Nume</th><td>{{ $order->client->name }}</td></tr>
<tr><th>Telefon</th><td>{{ $order->client->phone }} {{ $order->client->phone2 ? '/ '.$order->client->phone2 : '' }}</td></tr>
@if($order->client->email)<tr><th>Email</th><td>{{ $order->client->email }}</td></tr>@endif
@if($order->client->type == 'juridica')
@if($order->client->company)<tr><th>Companie</th><td>{{ $order->client->company }}</td></tr>@endif
@if($order->client->idno)<tr><th>IDNO</th><td>{{ $order->client->idno }}</td></tr>@endif
@if($order->client->cod_fiscal)<tr><th>Cod fiscal</th><td>{{ $order->client->cod_fiscal }}</td></tr>@endif
@if($order->client->cont_bancar)<tr><th>Cont bancar</th><td>{{ $order->client->cont_bancar }} ({{ $order->client->banca }})</td></tr>@endif
@if($order->client->adresa_juridica)<tr><th>Adresa juridica</th><td>{{ $order->client->adresa_juridica }}</td></tr>@endif
@endif
</tbody></table>

<div class="section-title">DISPOZITIV</div>
<table><tbody>
<tr><th>Tip dispozitiv</th><td>{{ $order->device_type }}</td></tr>
@if($order->device_brand || $order->device_model)<tr><th>Brand / Model</th><td>{{ $order->device_brand }} {{ $order->device_model }}</td></tr>@endif
@if($order->serial_number)<tr><th>Serie (S/N)</th><td>{{ $order->serial_number }}</td></tr>@endif
@if($order->accessories)<tr><th>Accesorii</th><td>{{ $order->accessories }}</td></tr>@endif
@if($order->device_condition)<tr><th>Stare la primire</th><td>{{ $order->device_condition }}</td></tr>@endif
</tbody></table>

@include('admin.service._doc_return_info')

<div class="section-title">PROBLEMA DESCRISA</div>
<table><tbody>
<tr><td>{{ $order->problem_description }}</td></tr>
</tbody></table>

<div class="section-title">ESTIMARE</div>
<table><tbody>
@if($order->estimated_price)<tr><th>Pret estimat</th><td>{{ number_format($order->estimated_price, 0) }} MDL</td></tr>@endif
@if($order->advance_payment > 0)<tr><th>Avans achitat</th><td>{{ number_format($order->advance_payment, 0) }} MDL</td></tr>@endif
@if($order->estimated_completion)<tr><th>Termen estimat</th><td>{{ $order->estimated_completion->format('d.m.Y') }}</td></tr>@endif
</tbody></table>

<div class="terms">
<strong>Conditii:</strong><br>
1. Clientul confirma ca dispozitivul a fost predat in starea descrisa mai sus.<br>
2. Termenul de reparatie este estimativ si poate fi modificat in functie de complexitatea lucrarii.<br>
3. Pretul final va fi comunicat dupa diagnostic si confirmat de client inainte de inceperea reparatiei.<br>
4. Dispozitivele nerevendicate in termen de 30 de zile de la finalizarea reparatiei vor fi considerate abandonate.<br>
5. Garantia se acorda doar pentru lucrarile efectuate, conform termenului specificat.
</div>

<table class="sig-table"><tr>
<td>Prestator (Comp.MD)</td>
<td>Client ({{ $order->client->name }})</td>
</tr></table>

</body></html>
