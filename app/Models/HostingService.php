<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostingService extends Model
{
    protected $fillable = [
        'client_id', 'hosting_package_id', 'type', 'name', 'domain',
        'registrar', 'server', 'price', 'currency', 'started_at',
        'expires_at', 'payment_due_at', 'is_paid', 'active',
        'last_notified_at', 'notes'
    ];

    protected $casts = [
        'started_at' => 'date',
        'expires_at' => 'date',
        'payment_due_at' => 'date',
        'last_notified_at' => 'date',
        'is_paid' => 'boolean',
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(ServiceClient::class, 'client_id');
    }

    public function package()
    {
        return $this->belongsTo(HostingPackage::class, 'hosting_package_id');
    }

    public function invoices()
    {
        return $this->hasMany(HostingInvoice::class);
    }

    public function latestInvoice()
    {
        return $this->hasOne(HostingInvoice::class)->latestOfMany();
    }

    public function ensurePaymentInvoice()
    {
        $invoice = HostingInvoice::where('hosting_service_id', $this->id)
            ->whereDate('service_expires_at', $this->expires_at->toDateString())
            ->first();

        if ($invoice) {
            return $invoice;
        }

        $nextNumber = (HostingInvoice::whereYear('issued_at', now()->year)->max('id') ?? 0) + 1;

        return HostingInvoice::create([
            'invoice_number' => 'HP-' . now()->year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT),
            'hosting_service_id' => $this->id,
            'client_id' => $this->client_id,
            'amount' => $this->price,
            'currency' => $this->currency,
            'issued_at' => now()->toDateString(),
            'due_at' => $this->payment_due_at->toDateString(),
            'service_expires_at' => $this->expires_at->toDateString(),
            'status' => 'unpaid',
        ]);
    }

    public static function typeList()
    {
        return [
            'hosting' => 'Hosting',
            'domain' => 'Domeniu',
        ];
    }

    public function getTypeLabelAttribute()
    {
        return self::typeList()[$this->type] ?? $this->type;
    }

    public function getDaysUntilPaymentAttribute()
    {
        return now()->startOfDay()->diffInDays($this->payment_due_at, false);
    }

    public function getStatusColorAttribute()
    {
        if (!$this->active) {
            return 'secondary';
        }

        if ($this->is_paid) {
            return 'success';
        }

        if ($this->payment_due_at && $this->payment_due_at->isPast()) {
            return 'danger';
        }

        if ($this->days_until_payment <= 7) {
            return 'warning';
        }

        return 'info';
    }
}
