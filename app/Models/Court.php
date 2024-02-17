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
}
