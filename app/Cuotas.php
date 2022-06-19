<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model
{
    //
    public $timestamps=false;
    public $incrementing = false;
    public function deudas(){
        return $this->belongsTo(Deudas::class);
    }
}
