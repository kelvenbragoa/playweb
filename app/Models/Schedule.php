<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function status(){
        return $this->hasOne('App\Models\Status','id','status_id');
    }

    public function price(){
        return $this->hasOne('App\Models\Price','id','price_id');
    }

    public function court(){
        return $this->hasOne('App\Models\Court','id','court_id');
    }

    public function players(){
        return $this->hasMany('App\Models\Player','schedule_id','id');
    }
}
