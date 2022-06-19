<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
    //
    protected $table="gastos";
    public $timestamps = false;
    public $incrementing = false;

    public function usuarios(){
        return $this->belongsTo(Usuarios::class,'user_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function categorias(){
        return $this->belongsTo(CategoriasGastos::class,'categoria_id');
    }
}
