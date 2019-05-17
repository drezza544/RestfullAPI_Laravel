<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pitstop;
use App\OrderDetail;

class Fasilitas extends Model
{

    protected $fillable = [
        'id', 'nama', 'harga', 'created_at', 'updated_at',
    ];

    public function pitstop_fasilitas()
    {
        return $this->belongsToMany('App\Pitstop', 'Pitstop__Fasilitas')->withTimestamps();
    }
    public function orderdetails()
    {
        return $this->belongsTo('App\OrderDetail');
    }
}
