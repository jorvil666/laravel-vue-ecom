<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos";
    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'stock',
        'precio',
        'imagen',
        'ratings',
        'fidelizacion',
        'puntos_canje',
        'estado'
    ];
    
    protected $casts = [
        'fidelizacion' => 'boolean',
        'estado' => 'boolean'
    ];

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
