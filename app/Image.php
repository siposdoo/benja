<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
class Image extends Model
{
    use Uuids;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }//
}
