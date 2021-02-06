<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nalog extends Model
{
    /**
* The attributes that are mass assignable.*
* @var array
*/
protected $fillable = [ 'vozila', 'vozac1', 'vozac2', 'uvoznocarinjenje', 'proizvodjac', 'prikolica', 'polaziste', 'placena', 'naziv', 'napomene', 'kontakt', 'kamion', 'izvoznocarinjenje', 'iznoskm', 'iznoseur', 'grprelaz', 'gmaplink', 'datumutovara', 'brfak', 'status', 'hash', 'kompanija'];


    public function utovaristovar()
    {
        return $this->hasMany('App\UtovarIstovar');
    }

    public function kompanija()
    {
        return $this->hasOne('App\Kompanija','id','kompanija');
    }
}
