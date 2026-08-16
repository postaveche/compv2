<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_ru', 'desc', 'desc_ru', 'image', 'link', 'active', 'sort_order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
