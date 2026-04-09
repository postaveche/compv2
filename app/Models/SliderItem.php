<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_id', 'title', 'title_ru', 'description', 'description_ru',
        'image', 'link', 'active', 'sort_order', 'views', 'clicks'
    ];

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function incrementClicks()
    {
        $this->increment('clicks');
    }
}
