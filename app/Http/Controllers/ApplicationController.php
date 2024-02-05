<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    //
    public function __invoke()
    
    {
     
        if(Auth::check()){
            if(Auth::user()->role_id == 1){
                return view('admin.layouts.app');
            }
            if(Auth::user()->role_id == 2){
                return view('user.app_layout');
            }
        }else{
            return view('user.app_layout');
        }
        
    }
}
