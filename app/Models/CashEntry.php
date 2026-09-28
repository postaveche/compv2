<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashEntry extends Model
{
    protected $fillable = [
        'client_id', 'service_order_id', 'created_by', 'client_name', 'description',
        'amount', 'payment_method', 'paid_at', 'source_type', 'source_key', 'voided_at', 'void_reason',
    ];

    protected $casts = ['amount' => 'decimal:2', 'paid_at' => 'datetime', 'voided_at' => 'datetime'];

    public static function methods(): array
    {
        return ['cash' => 'Cash', 'receipt' => 'Cec', 'transfer' => 'Transfer'];
    }

    public static function sources(): array
    {
        return ['manual' => 'Manual', 'advance' => 'Avans service', 'repair' => 'Achitare reparație', 'diagnosis' => 'Diagnosticare'];
    }

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
