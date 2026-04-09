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
