<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Review;
use App\Pitstop_Fasilitas;
use App\Fasilitas;
use App\Oder;

class Pitstop extends Model
{

    protected $fillable = [
        'user_id', 'nama', 'deskripsi', 'latitude', 'longitude', 'slot', 'harga'
    ];

    // protected $primaryKey = 'id';
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function pitstop_fasilitas()
    {
        return $this->belongsToMany('App\Fasilitas', 'Pitstop__Fasilitas')->withTimestamps();
    }
    
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
}
