<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cgastos extends Model
{
    //

    public $timestamps = false;
    public $incrementing = false;

    public function cuentas(){
        return $this->belongsTo(Cuentas::class);
    }

    public function bancos(){
        return $this->belongsTo(Bancos::class,'banco_id');
    }

    public function categorias(){
        return $this->belongsTo(CategoriasGastos::class,'categorias_id');
    }
}
