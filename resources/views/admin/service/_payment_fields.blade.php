<div class="border rounded p-2 mb-3 bg-light">
    <label for="service-payment-method">Metoda încasării</label>
    <select id="service-payment-method" name="payment_method" class="form-control mb-2">
        <option value="">Selectează pentru o încasare nouă</option>
        @foreach(\App\Models\CashEntry::methods() as $method => $label)
            <option value="{{ $method }}" {{ old('payment_method') === $method ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <label for="service-payment-date">Data și ora încasării</label>
    <input id="service-payment-date" type="datetime-local" name="payment_received_at" class="form-control" value="{{ old('payment_received_at') }}">
    <small class="text-muted d-block mt-2">Necompletat = momentul salvării. Avansul, soldul la bifarea „Achitat” și taxa de diagnosticare achitată se înregistrează în Casă. Debifarea sau modificarea sumelor păstrează înregistrarea anterioară ca anulată.</small>
</div>
