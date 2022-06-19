<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingresos extends Model
{
    //
    public $timestamps = false;
    public $incrementing = false;

    protected $table="ingresos";

    public function usuarios(){
        return $this->belongsTo(Usuarios::class,'user_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function categorias(){
        return $this->belongsTo(CategoriasIngresos::class,'categoria_id');
    }
}
