<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class Notification extends Controller
{
    //

    public function index($id){
        $user = User::find($id);

        // dd($user->notifications->pluck('data'));
        return response()->json([
            'notification'=>$user->notifications->pluck('data')
        ],200);
       
    }
}
