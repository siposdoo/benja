<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UtovarIstovar extends Model
{
    public function nalog()
    {
        return $this->belongsTo('App\Models\Nalog', 'nalog_id');
    }
}
