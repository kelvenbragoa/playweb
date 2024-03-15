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

        $courtschedule = Court::where('owner_id',Auth::user()->id)->first();
        $listcourt = Court::where('owner_id',Auth::user()->id)->get();
        $date = now()->subDay();
        $date2 = now()->addDays(5);
        $scheduleGroup = Schedule::with('court')->with('price.coin')->with('status')->with('players.user')->whereBetween('date',[$date,$date2])->where('court_id',$courtschedule->id)->orderBy('date','asc')->orderBy('start_time','asc')->get()->groupBy('date');

       
       



        return [
            'users' => $users,
            'courts' => $courts,
            'schedules' => $schedules,
            'courtsowner'=>$courtsowner,
            'schedulesowner'=>$schedulesowner,
            'dategroup'=>$scheduleGroup,
            'courtData'=>$courtData,
            'actualcourt'=>$courtschedule,
            'listcourt'=>$listcourt
        ];
    }

    public function updatedata($id){

        $date = now();
        $date2 = now()->addDays(6);
        $courtschedule = Court::find($id);
        $scheduleGroup = Schedule::with('court')->with('price.coin')->with('status')->with('players.user')->whereBetween('date',[$date,$date2])->where('court_id',$courtschedule->id)->orderBy('date','asc')->orderBy('start_time','asc')->get()->groupBy('date');

        return [
            
            'dategroup'=>$scheduleGroup,
            'actualcourt'=>$courtschedule,

        ];
    }

    public function updatescheduledashboard($date){

        $schedule = Schedule::with('court')->with('price.coin')->with('status')->where('date',$date)->orderBy('start_time','asc')->get()->groupBy('court.name');
        return $schedule;

    }
}
