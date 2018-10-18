<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function com_city(){
        return $this->hasOne(ComCity::class);
    }
    public function client(){
        return $this->hasOne(ComCity::class);
    }
    //
}
