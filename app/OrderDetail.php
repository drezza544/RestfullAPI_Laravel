<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Oder;
use App\Fasilitas;

class OrderDetail extends Model
{

    protected $fillable = [
        'order_id', 'fasilitas_id',
    ];

    public function orders()
    {
        return $this->belongsTo('App\Order');
    }
    public function fasilitas()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
