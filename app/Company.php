<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ComCity;

class Company extends Model
{
    use SoftDeletes;
    protected $fillable =['alias','name','info','info_for_vp_admin','id_city','percent','telephone','web_site','e_mail'];
    //

    public function comCity()
    {
        return $this->belongsTo(ComCity::class );
    }
}
