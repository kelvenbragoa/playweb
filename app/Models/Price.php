<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function coin(){
        return $this->hasOne('App\Models\Coin','id','coin_id');
    }
}
