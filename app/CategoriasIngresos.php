<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasIngresos extends Model
{
    //
    protected $table="categorias_ingresos";
    public $timestamps = false;

    public function ingresos(){
        return $this->hasMany(Ingresos::class,'categoria_id');
    }
}
