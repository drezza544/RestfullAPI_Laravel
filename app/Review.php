<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Pitstop;

class Review extends Model
{

    protected $fillable = [
        'pitstop_id', 'user_id', 'message', 'created_at', 'updated_at', 'rate'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    
    public function pitstops()
    {
        return $this->belongsTo('App\Pitstop');
    }
}
