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

    public static function normalizePhone($phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if (preg_match('/^0([0-9]{8})$/', $digits, $matches)
            || preg_match('/^(?:00)?373([0-9]{8})$/', $digits, $matches)) {
            return '373'.$matches[1];
        }
        return $digits;
    }

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class, 'client_id');
    }

    public function hostingServices()
    {
        return $this->hasMany(HostingService::class, 'client_id');
    }
}
