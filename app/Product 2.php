<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Product extends Model
{
    use Uuids;

    //
    public function user()
{
    return $this->belongsTo('App\Models\User', 'user_id');
}
public function images()
{
    return $this->hasMany('App\Models\Image');
}
public function prices()
{
    return $this->hasMany('App\Models\Price');
}
}
