<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(RolUsuario::class);
    }

     /**
     * Obtener el identificador que se almacenará en el JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Normalmente devuelve el ID del usuario
    }

    /**
     * Obtener los claims personalizados que se agregarán al JWT.
     */
    public function getJWTCustomClaims()
    {
        return []; // Puedes devolver un arreglo con claims personalizados si lo necesitas
    }
}
