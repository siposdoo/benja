<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kompanija extends Model
{
    public function nalog()
    {
        return $this->belongsTo('App\Models\Nalog', 'kompanija');
    }
}
