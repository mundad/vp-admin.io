<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function defrayment(){
        return $this->belongsTo(Defrayment::class);
    }
    //
}
