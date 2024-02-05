<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardDataController extends Controller
{
    //
    public function index(){
        $users=User::count();
        $courts=Court::count();
        $schedules=Schedule::count();
       



        return [
            'users' => $users,
            'courts' => $courts,
            'schedules' => $schedules,
           
        ];
    }
}
