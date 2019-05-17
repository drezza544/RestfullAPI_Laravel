<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderDetail;
use App\User;
use App\Pitstop;

class Order extends Model
{

    protected $fillable = [
        'id', 'kode_order', 'user_id', 'pitstop_id', 'tanggal', 'waktu_boking', 'harga'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function pitstops()
    {
        return $this->hasOne('App\Pitstop');
    }
    public function orderdetails()
    {
        return $this->hasOne('App\OrderDetail');
    }
}
