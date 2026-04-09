<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'client_id', 'device_type', 'device_brand',
        'device_model', 'serial_number', 'accessories', 'device_condition',
        'problem_description', 'diagnosis', 'work_done', 'parts_used',
        'status', 'estimated_price', 'final_price', 'advance_payment', 'is_paid', 'warranty',
        'warranty_days', 'estimated_completion', 'completed_at',
        'delivered_at', 'received_by', 'notes', 'is_return', 'parent_order_id',
        'is_warranty_repair', 'cancel_reason', 'diagnosis_fee', 'diagnosis_fee_paid'
    ];

    protected $casts = [
        'estimated_completion' => 'date',
        'completed_at' => 'datetime',
        'delivered_at' => 'datetime',
        'is_paid' => 'boolean',
        'warranty' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(ServiceClient::class, 'client_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function photos()
    {
        return $this->hasMany(ServicePhoto::class, 'order_id');
    }

    public function parentOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'parent_order_id');
    }

    public function returnOrders()
    {
        return $this->hasMany(ServiceOrder::class, 'parent_order_id');
    }

    public static function generateOrderNumber()
    {
        $year = date('Y');
        $last = self::whereYear('created_at', $year)->max('id');
        $next = ($last ?? 0) + 1;
        return 'SC-' . $year . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public static function statusList()
    {
        return [
            'received' => 'Primit',
            'diagnosis' => 'Diagnosticare',
            'waiting_approval' => 'Asteapta confirmare client',
            'in_repair' => 'In reparatie',
            'waiting_parts' => 'Asteptare piese',
            'repaired' => 'Reparat',
            'delivered' => 'Predat clientului',
            'returned_unrepaired' => 'Returnat fara reparatie',
            'cancelled' => 'Anulat',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::statusList()[$this->status] ?? $this->status;
    }
}
