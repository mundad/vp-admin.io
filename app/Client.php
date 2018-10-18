<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function defrayments(){
        return $this->hasMany(Defrayment::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
    //
}
