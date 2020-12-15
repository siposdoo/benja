<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Picture extends Model
{
    use Uuids;
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }//
}
