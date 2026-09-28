<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CashEntry;
use App\Models\ServiceClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CashController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'from' => 'nullable|date_format:Y-m-d',
            'to' => 'nullable|date_format:Y-m-d'.($request->filled('from') ? '|after_or_equal:from' : ''),
            'client_id' => 'nullable|integer',
            'payment_method' => ['nullable', Rule::in(array_keys(CashEntry::methods()))],
            'show_voided' => 'nullable|boolean',
        ]);
        $query = CashEntry::query();
        if (!empty($filters['from'])) $query->where('paid_at', '>=', $filters['from'].' 00:00:00');
        if (!empty($filters['to'])) $query->where('paid_at', '<=', $filters['to'].' 23:59:59');
        if (!empty($filters['client_id'])) $query->where('client_id', $filters['client_id']);
        if (!empty($filters['payment_method'])) $query->where('payment_method', $filters['payment_method']);
        $totals = (clone $query)->whereNull('voided_at')->selectRaw('payment_method, SUM(amount) as total')->groupBy('payment_method')->pluck('total', 'payment_method');
        if (!$request->boolean('show_voided')) $query->whereNull('voided_at');
        $entries = $query->with('order', 'author')->orderByDesc('paid_at')->orderByDesc('id')->paginate(30)->withQueryString();
        $clients = ServiceClient::orderBy('name')->get(['id', 'name', 'phone']);
        return view('admin.cash.index', compact('entries', 'clients', 'totals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:service_clients,id',
            'description' => 'required|string|max:500',
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'payment_method' => ['required', Rule::in(array_keys(CashEntry::methods()))],
            'paid_at' => 'required|date_format:Y-m-d\TH:i',
            'submission_token' => 'required|uuid',
        ]);
        $key = 'manual:'.$request->user()->id.':'.$data['submission_token'];
        unset($data['submission_token']);
        $data['client_name'] = ServiceClient::findOrFail($data['client_id'])->name;
        $data['created_by'] = $request->user()->id;
        $data['source_type'] = 'manual';
        // The unique key also protects against concurrent retries of the same form.
        try {
            CashEntry::firstOrCreate(['source_key' => $key], $data);
        } catch (\Illuminate\Database\QueryException $exception) {
            if (!CashEntry::where('source_key', $key)->exists()) throw $exception;
        }
        return redirect()->route('cash.index')->with('success', 'Încasarea a fost înregistrată.');
    }
}
