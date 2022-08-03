<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carrito extends Model
{
    use HasFactory;

    protected $table = "carrito";
    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio',
        'user_id',
        'created_at'
    ];
    protected $hidden = ['id'];

    public function producto()
    {
        return $this-> hasMany(Producto::class, 'id', 'producto_id');
    }
}
