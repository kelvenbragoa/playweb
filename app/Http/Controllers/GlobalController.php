<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Price;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    //
    public function auxiliardataschedules(){

        $courts = Court::orderBy('id','asc')->get();
        $prices = Price::orderBy('name','asc')->get();
       

        return [
                'prices'=>$prices,
                'courts'=>$courts,
                ];
    }
}
