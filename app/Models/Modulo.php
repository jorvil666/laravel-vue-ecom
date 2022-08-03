<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $table = "Modulos";
    public $timestamps = false;
    protected $primaryKey = 'IdModulos';
    protected $fillable = [
        'NombreMod',
        'DescripcionMod',
        'RutaMod',
        'IconoMod',
        'EstadoMod'
    ];

    protected $casts = ['EstadoMod' => 'boolean'];


}
