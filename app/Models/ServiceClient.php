<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'name', 'phone', 'phone2', 'email',
        'company', 'idno', 'cod_fiscal', 'cont_bancar',
        'banca', 'adresa_juridica', 'notes'
    ];

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class, 'client_id');
    }
}
