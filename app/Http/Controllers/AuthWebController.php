<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthWebController extends Controller
{
    //
    public function loginuser(Request $request){

      
        $data = $request->all();

        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => 1])){
            return response(
               [ 'message' => 'Usuario/Password Incorretos'], 403
            );
        }
        // $yesterday = Carbon::yesterday();

        // $today_tax = Payments::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->sum('amount');
        // $yesterday_tax = Payments::where('user_id',auth()->user()->id)->whereDate('created_at',$yesterday)->sum('amount');
        // $month_tax = Payments::where('user_id',auth()->user()->id)->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->sum('amount');
        // $year_tax = Payments::where('user_id',auth()->user()->id)->whereYear('created_at',date('Y'))->sum('amount');
        
        return response([
            'user' => auth()->user(),
            // 'dashboard'=>[
            //     'today'=>$today_tax,
            //     'yesterday'=>$yesterday_tax,
            //     'month'=>$month_tax,
            //     'year'=>$year_tax,
            // ]
            // 'token' => auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }
}
