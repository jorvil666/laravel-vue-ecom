<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    use HasFactory;

    protected $table = "empresa";
    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'email',
        'telefono',
        'impuesto',
        'delivery',
        'valor_delivery',
        'fidelizacion',
        'condiciones'
    ];
    
    protected $casts = [
        'fidelizacion' => 'boolean',
        'delivery' => 'boolean'
    ];
}
