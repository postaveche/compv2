<div class="section-title">DISPOZITIV</div>
<table><tbody>
<tr><th>Tip dispozitiv</th><td>{{ $order->device_type }}</td></tr>
@if($order->device_brand || $order->device_model)<tr><th>Brand / Model</th><td>{{ $order->device_brand }} {{ $order->device_model }}</td></tr>@endif
@if($order->serial_number)<tr><th>Serie (S/N)</th><td>{{ $order->serial_number }}</td></tr>@endif
@if($order->accessories)<tr><th>Accesorii</th><td>{{ $order->accessories }}</td></tr>@endif
@if($order->device_condition)<tr><th>Stare la primire</th><td>{{ $order->device_condition }}</td></tr>@endif
</tbody></table>
