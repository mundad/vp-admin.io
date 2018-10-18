<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;

class ComCity extends Model
{
    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function country(){
        return$this->belongsTo(Country::class);
    }
    //
}
