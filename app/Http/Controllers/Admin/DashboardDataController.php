<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardDataController extends Controller
{
    //
    public function indexadmin(){
        $users=User::count();
        $courts=Court::count();
        $schedules=Schedule::count();

        $courtsowner = Court::where('owner_id',Auth::user()->id)->count();
        $schedulesowner = Schedule::where('owner_id',Auth::user()->id)->where('status_id','!=',1)->where('date',date('Y-m-d'))->count();
       



        return [
            'users' => $users,
            'courts' => $courts,
            'schedules' => $schedules,
            'courtsowner'=>$courtsowner,
            'schedulesowner'=>$schedulesowner
        ];
    }








    public function index(){
        $users=User::count();
        $courts=Court::count();
        $schedules=Schedule::count();

        $courtsowner = Court::where('owner_id',Auth::user()->id)->count();
        // $courtData= Court::where('owner_id',Auth::user()->id)->with('schedules')->get();
        $courtData = Schedule::with('court')->with('price.coin')->with('status')->where('date',date('Y-m-d'))->orderBy('start_time','asc')->get()->groupBy('court.name');
        $schedulesowner = Schedule::where('owner_id',Auth::user()->id)->where('status_id','!=',1)->where('date',date('Y-m-d'))->count();
       



        return [
            'users' => $users,
            'courts' => $courts,
            'schedules' => $schedules,
            'courtsowner'=>$courtsowner,
            'schedulesowner'=>$schedulesowner,

            'courtData'=>$courtData,
        ];
    }

    public function updatescheduledashboard($date){

        $schedule = Schedule::with('court')->with('price.coin')->with('status')->where('date',$date)->orderBy('start_time','asc')->get()->groupBy('court.name');
        return $schedule;

    }
}
