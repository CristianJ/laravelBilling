<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    //
    public $timestamps = false;

    public function cuentas(){
        return $this->hasMany(Cuentas::class,'banco_id');
    }


}
