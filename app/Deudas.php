<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deudas extends Model


{
    public $timestamps = false;
    public $incrementing = false;
    //
    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function cuotas(){
        return $this->hasMany(Cuotas::class,'deuda_id');
    }
}
