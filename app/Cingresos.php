<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cingresos extends Model
{
    //
    public $timestamps = false;
    public $incrementing = false;

    public function cuentas(){
        return $this->belongsTo(Cuentas::class);
    }

    public function categorias(){
        return $this->belongsTo(CategoriasIngresos::class,'categorias_id');
    }
}
