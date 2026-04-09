<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'image', 'description', 'stage'];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'order_id');
    }
}
