<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // public $connection='usuarioconex';
    protected $primaryKey='id_usuario';
    protected $table='usuarios';
    public $timestamps=false;
    public $incrementing=false;
    protected $fillable = [
        'id_usuario', 'usuario', 'contrasena',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'contrasena',
    ];

    public function getAuthPassword() {
    return $this->contrasena;
    }
}
