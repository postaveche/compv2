<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position', 'category_ids', 'active', 'sort_order'];

    protected $casts = [
        'category_ids' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(SliderItem::class)->orderBy('sort_order');
    }

    public function activeItems()
    {
        return $this->hasMany(SliderItem::class)->where('active', 1)->orderBy('sort_order');
    }
}
