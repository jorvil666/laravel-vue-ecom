<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabeceraPedido extends Model
{
    use HasFactory;

    protected $table = "cabecera_pedido";
    protected $fillable = [
        'user_id',
        'impuesto',
        'subtotal',
        'iva',
        'total',
        'forma_pago',
        'estado',
        'fecha_creacion'
    ];

    public $timestamps = false;

    public function cliente()
    {
        $this->belongsTo(User::class);
    }

    public function detalle()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
