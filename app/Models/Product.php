<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    public $table = 'product';
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function selectCategory(){
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
