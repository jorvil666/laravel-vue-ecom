<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class UsuarioTienda extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = "usuarios_tienda";
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'estado'
    ];
    
    protected $casts = [
        'estado' => 'boolean'
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
