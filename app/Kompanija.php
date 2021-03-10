<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kompanija extends Model
{
    public function nalog()
    {
        return $this->hasMany('App\Nalog', 'kompanija');
    }
    
}
