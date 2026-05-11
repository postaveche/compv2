<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostingInvoice extends Model
{
    protected $fillable = [
        'invoice_number', 'hosting_service_id', 'client_id', 'amount',
        'currency', 'issued_at', 'due_at', 'service_expires_at',
        'status', 'paid_at'
    ];

    protected $casts = [
        'issued_at' => 'date',
        'due_at' => 'date',
        'service_expires_at' => 'date',
        'paid_at' => 'date',
        'amount' => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(HostingService::class, 'hosting_service_id');
    }

    public function client()
    {
        return $this->belongsTo(ServiceClient::class, 'client_id');
    }
}
