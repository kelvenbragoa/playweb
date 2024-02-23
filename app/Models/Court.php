<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function club(){
        return $this->hasOne('App\Models\Club','id','club_id');
    }

    public function schedules(){
        return $this->hasMany('App\Models\Schedule','court_id','id')->where('date',date('Y-m-d'));
    }


}
