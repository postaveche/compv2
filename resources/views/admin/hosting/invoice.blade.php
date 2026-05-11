<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <title>Cont de plata {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #222; margin: 40px; font-size: 14px; }
        .top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        h1 { margin: 0 0 8px; font-size: 26px; }
        h2 { margin: 0 0 12px; font-size: 18px; }
        .muted { color: #666; }
        .box { border: 1px solid #ddd; padding: 16px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f3f3f3; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .actions { margin-bottom: 20px; }
        @media print { .actions { display: none; } body { margin: 20px; } }
    </style>
</head>
<body>
<div class="actions">
    <button onclick="window.print()">Printeaza</button>
    <button onclick="window.close()">Inchide</button>
</div>

<div class="top">
    <div>
        <h1>Cont de plata</h1>
        <div class="muted">Nr. {{ $invoice->invoice_number }}</div>
    </div>
    <div><img src="{{ asset('logo.png') }}" alt="Comp.MD" style="height: 58px;"></div>
</div>

<div class="box">
    <h2>Rechizite de plata</h2>
    <strong>"IT SERVICE GRUP" S.R.L.</strong><br>
    R.Moldova or. Chisinau str. Socoleni 15 of. 37 zip: 2020<br>
    IDNO: 1010600045304<br>
    Cod TVA: 0608553<br>
    IBAN: <strong>MD47MO2224ASV84387867100</strong><br>
    Mobiasbanca - Groupe Societe Generale S.A.<br>
    BIC: <strong>MOBBMD22</strong>
</div>

<div class="box">
    <h2>Client</h2>
    <strong>{{ $invoice->client->name }}</strong><br>
    @if($invoice->client->company) Companie: {{ $invoice->client->company }}<br>@endif
    @if($invoice->client->phone) Telefon: {{ $invoice->client->phone }}<br>@endif
    @if($invoice->client->email) Email: {{ $invoice->client->email }}<br>@endif
    @if($invoice->client->idno) IDNO: {{ $invoice->client->idno }}<br>@endif
</div>

<div class="box">
    Emis la: <strong>{{ $invoice->issued_at->format('d.m.Y') }}</strong><br>
    De achitat pana la: <strong>{{ $invoice->due_at->format('d.m.Y') }}</strong><br>
    Status: <strong>{{ $invoice->status == 'paid' ? 'Achitat' : 'Neachitat' }}</strong>
</div>

<table>
    <thead>
    <tr>
        <th>Serviciu</th>
        <th>Domeniu</th>
        <th>Perioada</th>
        <th>Suma</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $invoice->service->type_label }}: {{ $invoice->service->name }} @if($invoice->service->package)<br><span class="muted">Pachet: {{ $invoice->service->package->name }}</span>@endif</td>
        <td>{{ $invoice->service->domain ?? '-' }}</td>
        <td>{{ $invoice->service_expires_at->format('d.m.Y') }} - {{ $invoice->service_expires_at->copy()->addYear()->format('d.m.Y') }}</td>
        <td>{{ number_format($invoice->amount, 2) }} {{ $invoice->currency }}</td>
    </tr>
    </tbody>
</table>

<div class="total">Total: {{ number_format($invoice->amount, 2) }} {{ $invoice->currency }}</div>
</body>
</html>
