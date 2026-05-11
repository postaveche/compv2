<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostingPackage extends Model
{
    protected $fillable = [
        'name', 'price', 'currency', 'period', 'description', 'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function services()
    {
        return $this->hasMany(HostingService::class);
    }
}
