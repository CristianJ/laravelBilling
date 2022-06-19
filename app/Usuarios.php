<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    //
    protected $table="users";
    public $timestamps = false;

    public function ingresos(){
        return $this->hasMany(Ingresos::class,'user_id');
    }

    public function gastos(){
        return $this->hasMany(Gastos::class,'user_id');
    }

    public function cuentas(){
        return $this->hasMany(Cuentas::class,'user_id');
    }



    public function deudas(){
        return $this->hasMany(Deudas::class,'usuario_id');
    }

}
