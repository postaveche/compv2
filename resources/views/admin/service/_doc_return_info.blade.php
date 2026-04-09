@if($order->is_return)
<div class="section-title" style="background:#fff3cd;">RETUR - DISPOZITIV REPARAT ANTERIOR</div>
<table><tbody>
@if($order->is_warranty_repair)
<tr><th>Tip retur</th><td><strong>Reparatie pe garantie</strong></td></tr>
@endif
<tr><th>Comanda anterioara</th><td>{{ $order->parentOrder ? $order->parentOrder->order_number : '-' }}
@if($order->parentOrder) (din {{ $order->parentOrder->created_at->format('d.m.Y') }})@endif</td></tr>
@if($order->parentOrder && $order->parentOrder->work_done)
<tr><th>Lucrari anterioare</th><td>{{ $order->parentOrder->work_done }}</td></tr>
@endif
@if($order->parentOrder && $order->parentOrder->warranty)
<tr><th>Garantie anterioara</th><td>{{ $order->parentOrder->warranty_days }} zile (din {{ $order->parentOrder->completed_at ? $order->parentOrder->completed_at->format('d.m.Y') : '-' }})</td></tr>
@endif
</tbody></table>
@endif
@if($order->status == 'returned_unrepaired' && $order->cancel_reason)
<div class="section-title" style="background:#f8d7da;">RETURNAT FARA REPARATIE</div>
<table><tbody>
<tr><th>Cauza</th><td>{{ $order->cancel_reason }}</td></tr>
@if($order->diagnosis_fee > 0)
<tr><th>Taxa diagnosticare</th><td>{{ number_format($order->diagnosis_fee, 0) }} MDL {{ $order->diagnosis_fee_paid ? '(achitata)' : '(neachitata)' }}</td></tr>
@endif
</tbody></table>
@endif
