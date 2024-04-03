<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function loginuserweb(Request $request){

      
        $data = $request->all();

        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => 1])){
            return response(
               [ 'message' => 'Usuario/Password Incorretos'], 403
            );
        }
        
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ],200);


  
}
    public function loginuser(Request $request){

      
        $data = $request->all();

        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => 3])){
            return response(
               [ 'message' => 'Usuario/Password Incorretos'], 403
            );
        }
        
        return response([
            'user' => auth()->user(),
            // 'token' => auth()->user()->createToken('secret')->plainTextToken
        ],200);


  
}

public function registeruser(Request $request){

    $data = $request->all();

   

    $userteste = User::where('email',$data['email'])->orWhere('mobile',$data['mobile'])->count();

    if($userteste > 0){
        return response(
            [ 'message' => 'Existe um usuario com estas credenciais. Inicie a sessao'],403
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
            'role_id'=>3,
            'balance'=>0
        ]);

        $user = User::find($newuser->id);

        return response( 
            ['user'=>$user],200
        );
    }
}
}
