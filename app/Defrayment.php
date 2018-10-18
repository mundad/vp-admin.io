<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defrayment extends Model
{
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
    //
}
