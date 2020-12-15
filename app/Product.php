<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Product extends Model
{
    use Uuids;
/**
* The attributes that are mass assignable.*
* @var array
*/
protected $fillable = [
    'sifradobavljaca', 'kategorija', 'subkategorija', 'proizvodjac', 'brojmodela', 'naslovweb', 'podnaslovweb', 'opis', 'tehnckekar', 'dimenizije', 'snaga', 'napon', 'zapremina', 'duzinakabla', 'tezina', 'periodgarancije', 'porukagarancija', 'videoproizvoda', 'kolicina', 'pjcijena', 'starapjcijena', 'shopcijena', 'mincijena', 'fixcijena', 'otvoritiprije', 'posebnanapomena', 'napomenazasop', 'porukatovarni', 'predlozenimreze', 'linkproizvodjaca', 'premium', 'lokacijausklad', 'porukazasop', 'state', 'us_id'
    ];


    public function user()
{
    return $this->belongsTo('App\User', 'user_id');
}
public function pictures()
{
    return $this->hasMany('App\Picture', 'product_id','id');
}
public function prices()
{
    return $this->hasMany('App\Price');
}
}
