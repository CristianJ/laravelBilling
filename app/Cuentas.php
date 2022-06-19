<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    //
        public function bancos(){
            return $this->belongsTo(Bancos::class,'banco_id');
        }

        public function usuarios(){
            return $this->belongsTo(Usuarios::class,'user_id');
        }

        public function cgastos(){
            return $this->hasMany(Cgastos::class,'cuentas_id');
        }

        public function cingresos(){
            return $this->hasMany(Cingresos::class,'cuentas_id');
        }
}
