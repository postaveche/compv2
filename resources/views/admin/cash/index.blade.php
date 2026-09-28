@extends('admin.layouts.adminlayouts')
@section('title', 'Casă — încasări')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div><h1>Casă</h1><p class="text-muted mb-0">Registrul încasărilor · MDL</p></div>
            <form method="POST" action="{{ route('cash.lock') }}">@csrf<button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fas fa-lock mr-1"></i> Blochează accesul</button></form>
        </div>
    </div></section>
    <section class="content"><div class="container-fluid">
        @include('admin.block.messages')
        @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="row">
            <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3>{{ number_format($totals->sum(), 2, ',', ' ') }}</h3><p>Total încasări</p></div><div class="icon"><i class="fas fa-wallet"></i></div></div></div>
            @foreach(\App\Models\CashEntry::methods() as $method => $label)
            <div class="col-lg-3 col-6"><div class="small-box bg-{{ ['cash' => 'success', 'receipt' => 'primary', 'transfer' => 'secondary'][$method] }}"><div class="inner"><h3>{{ number_format($totals[$method] ?? 0, 2, ',', ' ') }}</h3><p>{{ $label }}</p></div><div class="icon"><i class="fas fa-{{ ['cash' => 'money-bill-wave', 'receipt' => 'receipt', 'transfer' => 'university'][$method] }}"></i></div></div></div>
            @endforeach
        </div>
        <p class="text-muted small">Totalurile respectă filtrele selectate și exclud înregistrările anulate.</p>

        <div class="card card-outline card-success">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> Încasare nouă</h3></div>
            <form method="POST" action="{{ route('cash.store') }}">@csrf
                <input type="hidden" name="submission_token" value="{{ old('submission_token', (string) \Illuminate\Support\Str::uuid()) }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group"><label for="cash-client">Client</label><select id="cash-client" name="client_id" class="form-control" required><option value="">Selectează clientul</option>@foreach($clients as $client)<option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} — {{ $client->phone }}</option>@endforeach</select></div>
                        <div class="col-md-3 form-group"><label for="cash-amount">Sumă (MDL)</label><input id="cash-amount" name="amount" type="number" min="0.01" max="9999999999.99" step="0.01" inputmode="decimal" class="form-control" value="{{ old('amount') }}" required></div>
                        <div class="col-md-3 form-group"><label for="cash-method">Metodă de plată</label><select id="cash-method" name="payment_method" class="form-control" required><option value="">Selectează metoda</option>@foreach(\App\Models\CashEntry::methods() as $method => $label)<option value="{{ $method }}" {{ old('payment_method') === $method ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 form-group"><label for="cash-description">Pentru ce s-a achitat</label><input id="cash-description" name="description" class="form-control" maxlength="500" value="{{ old('description') }}" placeholder="Ex.: reparație, vânzare accesorii, alte servicii" required></div>
                        <div class="col-md-4 form-group"><label for="cash-date">Data și ora încasării</label><input id="cash-date" name="paid_at" type="datetime-local" class="form-control" value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}" required></div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Înregistrează încasarea</button>
                    <small class="text-muted d-block mt-2">Plățile salvate în reparații apar automat aici. Nu le introduce încă o dată manual.</small>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Încasări <span class="badge badge-light ml-1">{{ $entries->total() }}</span></h3></div>
            <div class="card-body border-bottom">
                <form method="GET" action="{{ route('cash.index') }}">
                    <div class="row">
                        <div class="col-md-2 form-group"><label for="cash-from">De la</label><input id="cash-from" name="from" type="date" class="form-control form-control-sm" value="{{ request('from') }}"></div>
                        <div class="col-md-2 form-group"><label for="cash-to">Până la</label><input id="cash-to" name="to" type="date" class="form-control form-control-sm" value="{{ request('to') }}"></div>
                        <div class="col-md-4 form-group"><label for="cash-filter-client">Client</label><select id="cash-filter-client" name="client_id" class="form-control form-control-sm"><option value="">Toți clienții</option>@foreach($clients as $client)<option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>@endforeach</select></div>
                        <div class="col-md-2 form-group"><label for="cash-filter-method">Metodă</label><select id="cash-filter-method" name="payment_method" class="form-control form-control-sm"><option value="">Toate metodele</option>@foreach(\App\Models\CashEntry::methods() as $method => $label)<option value="{{ $method }}" {{ request('payment_method') === $method ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
                        <div class="col-md-2 form-group d-flex align-items-end"><button class="btn btn-primary btn-sm mr-2" type="submit">Filtrează</button><a href="{{ route('cash.index') }}" class="btn btn-default btn-sm">Reset</a></div>
                    </div>
                    <label class="mb-0 font-weight-normal"><input type="checkbox" name="show_voided" value="1" {{ request()->boolean('show_voided') ? 'checked' : '' }}> Arată și înregistrările anulate prin corectarea reparațiilor</label>
                </form>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Data și ora</th><th>Client</th><th>Pentru ce s-a achitat</th><th>Metodă</th><th class="text-right">Sumă (MDL)</th><th>Sursă / operator</th></tr></thead>
                    <tbody>@forelse($entries as $entry)
                        <tr class="{{ $entry->voided_at ? 'text-muted' : '' }}">
                            <td class="text-nowrap">{{ $entry->paid_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $entry->client_name }}</td>
                            <td>{{ $entry->description }}@if($entry->voided_at)<br><span class="badge badge-secondary">Anulată</span> <small>{{ $entry->void_reason }}</small>@endif</td>
                            <td><span class="badge badge-light">{{ \App\Models\CashEntry::methods()[$entry->payment_method] ?? $entry->payment_method }}</span></td>
                            <td class="text-right text-nowrap font-weight-bold">{{ number_format($entry->amount, 2, ',', ' ') }}</td>
                            <td>{{ \App\Models\CashEntry::sources()[$entry->source_type] ?? $entry->source_type }}@if($entry->order)<br><a href="{{ route('service.show', $entry->service_order_id) }}">{{ $entry->order->order_number }}</a>@endif<br><small class="text-muted">{{ $entry->author->name ?? '—' }}</small></td>
                        </tr>
                    @empty<tr><td colspan="6" class="text-center text-muted py-4">Nu există încasări pentru filtrele selectate.</td></tr>@endforelse</tbody>
                </table>
            </div>
            @if($entries->hasPages())<div class="card-footer">{{ $entries->links() }}</div>@endif
        </div>
    </div></section>
</div>
<script>
// Browsers may restore a page from their back/forward cache without a request.
window.addEventListener('pageshow', function (event) { if (event.persisted) window.location.reload(); });
</script>
@endsection
