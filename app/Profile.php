<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Profile extends Model
{

    protected $fillable = [
        'id', 'user_id', 'alamat', 'tgl_lahir', 'path'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
