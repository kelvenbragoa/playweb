<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function loginuser(Request $request){

      
        $data = $request->all();

        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => 2])){
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
   
    
    // $credentials = $request->validate([
    //     'email' => ['required', 'email'],
    //     'password' => ['required'],
    // ]);

    // if (Auth::attempt($credentials)) {
    //     $request->session()->regenerate();

    //     return redirect()->intended('dashboard');
    // }

    // return back()->withErrors([
    //     'email' => 'The provided credentials do not match our records.',
    // ])->onlyInput('email');

  
}

public function registeruser(Request $request){

    $data = $request->all();

   

    $userteste = User::where('email',$data['email'])->orWhere('mobile',$data['mobile'])->first();

    if($userteste != null){
        return response(
            [ 'message' => 'Existe um usuário com estas credenciais. Inicie a sessão'],403
         );
    }else{
        $gender = $data['gender']=='Male' ? 1 : 2;
        $newuser = User::create([
            'name'=>$data['first_name'],
            'surname'=>$data['last_name'],
            'mobile'=>$data['mobile'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']) ,
            'birth_date'=>$data['birth_date'],
            'gender_id'=>$gender,
            'role_id'=>2
            
        ]);

        $user = User::find($newuser->id);

        return response( 
            ['user'=>$user],200
        );
    }
}
}
