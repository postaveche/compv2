<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = "category";
    use HasFactory;

    public function subcategory(){
        return $this->hasMany(self::class, 'id', 'subcat');
    }

    public function maincategory(){
        return $this->belongsTo(self::class, 'subcat', 'id');
    }
}
