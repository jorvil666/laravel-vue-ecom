<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloUsuario extends Model
{
    use HasFactory;

    protected $table = "PermisosUsuarios";
    protected $fillable = [
        'IdUsuario',
        'IdModulo',
    ];

    public $timestamps = false;

    public function usuario()
    {
        $this->belongsTo(User::class);
    }

    public function modulo()
    {
        $this->belongsTo(Modulo::class);
    }
}
