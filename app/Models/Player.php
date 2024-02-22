<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function schedule(){
        return $this->hasOne('App\Models\Schedule','id','schedule_id');
    }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function transaction(){
        return $this->hasOne('App\Models\Transaction','player_id','id');
    }
    
}
