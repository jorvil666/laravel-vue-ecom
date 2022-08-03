<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = "detalle_pedido";
    protected $fillable = [
        'cabecera_pedido_id',
        'producto_id',
        'cantidad',
        'precio'
    ];

    public $timestamps = false;

    public function cabecera()
    {
        $this->belongsTo(CabeceraPedido::class);
    }

    public function producto()
    {
        $this->belongsTo(Producto::class);
    }
}
