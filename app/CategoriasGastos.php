<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasGastos extends Model
{
    //
    protected $table="categorias_gastos";
    public $timestamps = false;

    public function gastos(){
        return $this->hasMany(Gastos::class,'categoria_id');
    }
}
