<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Coin;
use App\Models\Court;
use App\Models\Price;
use App\Models\Province;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    //
    public function auxiliardataschedules(){

        $courts = Court::orderBy('id','asc')->get();
        $prices = Price::orderBy('name','asc')->get();
        $provinces = Province::get();
        $coins = Coin::get();
       

        return [
                'prices'=>$prices,
                'courts'=>$courts,
                'provinces'=>$provinces,
                'coins'=>$coins
                ];
    }

    public function home(){
        $clubs = Club::orderBy('id','asc')->with('province')->with('user')->get();
        $prices = Price::orderBy('name','asc')->get();
        return [
            'prices'=>$prices,
            'clubs'=>$clubs,
            ];
    }

    public function clubs($id){

        $courts = Court::where('club_id',$id)->orderBy('id','asc')->get();
        $club = Club::with('province')->with('user')->find($id);

        return [
            'club'=>$club,
            'courts'=>$courts,
            ];
    }

    public function schedule($id){
        $schedule = Schedule::with('status')->with('price')->with('court')->where('court_id',$id)->where('date',date('Y-m-d'))->orderBy('start_time','asc')->get();
        $court = Court::with('club.province')->find($id);

        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(6);
  
        $dateRange = CarbonPeriod::create($startDate, $endDate);
   
        

        return [
            'schedule'=>$schedule,
            'court'=>$court,
            'dates'=>$dateRange
        ];
    }

    public function updateschedule($date,$id){
        $schedule = Schedule::with('status')->with('price')->with('court')->where('court_id',$id)->where('date',$date)->orderBy('start_time','asc')->get();
        $court = Court::with('club.province')->find($id);

        return [
            'schedule'=>$schedule,
            'court'=>$court,
        ];
    }
}
