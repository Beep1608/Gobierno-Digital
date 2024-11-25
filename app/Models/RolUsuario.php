<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RolUsuario extends Model
{
    //
    protected $table = "role_user";

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function roles(): HasMany
    {
        return $this->hasMany(Rol::class);
    }
}
