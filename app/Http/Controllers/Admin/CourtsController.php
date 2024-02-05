<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourtsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

            $courts = Court::query()
            ->when(request('query'),function($query,$searchQuery){
                $query->where('name','like',"%{$searchQuery}%");
            })
            
            ->orderBy('name','asc')
            ->paginate();


            return $courts;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        $request->validate([
            'firstName' =>'required',
            'lastName' =>'required',
            'address' =>'required',
            'code' =>'required',
            'bi' =>'required',
            'mobile' =>'required|min:9',
            'cellphone' =>'required|min:9',
            'province_id' =>'required',
            'city_id' =>'required',
            'user_status_id' =>'required',
            'role_id' =>'required',
            'account_status_id' =>'required',
            'email' =>'required|unique:courts,email',
            'password' =>'required|min:8',
            
        ]);

        if($data['role_id']==2 || $data['role_id']==3 || $data['role_id']==4 | $data['role_id']==11 | $data['role_id']==12 | $data['role_id']==13 | $data['role_id']==14 | $data['role_id']==15 | $data['role_id']==16)
        {
            $user = Court::create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'address' => $data['address'],
                'code' => $data['code'],
                'bi' => $data['bi'],
                'mobile' => $data['mobile'],
                'cellphone' => $data['cellphone'],
                'country_id' => 1,
                'province_id' => $data['province_id'],
                'city_id' => $data['city_id'],
                'user_status_id' => $data['user_status_id'],
                'role_id' => $data['role_id'],
                'account_status_id' => $data['account_status_id'],
                'email' => strtolower($data['email']),
                'password' => bcrypt($data['password']),
            ]);
    
            return $user;
        }

        if($data['role_id']==5 || $data['role_id']==6 || $data['role_id']==7 )
        {
            $user = Court::create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'address' => $data['address'],
                'code' => $data['code'],
                'bi' => $data['bi'],
                'mobile' => $data['mobile'],
                'cellphone' => $data['cellphone'],
                'area_id' => $data['area_id'],
                'country_id' => 1,
                'province_id' => $data['province_id'],
                'city_id' => $data['city_id'],
                'user_status_id' => $data['user_status_id'],
                'role_id' => $data['role_id'],
                'account_status_id' => $data['account_status_id'],
                'email' => strtolower($data['email']),
                'password' => bcrypt($data['password']),
            ]);
    
            return $user;
        }

        if($data['role_id']==8 || $data['role_id']==9 || $data['role_id']==10 )
        {
            $user = Court::create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'address' => $data['address'],
                'code' => $data['code'],
                'bi' => $data['bi'],
                'mobile' => $data['mobile'],
                'cellphone' => $data['cellphone'],
                'destination_id' => $data['destination_id'],
                'country_id' => 1,
                'province_id' => $data['province_id'],
                'city_id' => $data['city_id'],
                'user_status_id' => $data['user_status_id'],
                'role_id' => $data['role_id'],
                'account_status_id' => $data['account_status_id'],
                'email' => strtolower($data['email']),
                'password' => bcrypt($data['password']),
            ]);
    
            return $user;
        }



        



        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $court = Court::
        find($id);

        return $court;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // $user = Court::find($id);
        // $roles = Role::orderBy('name','asc')->get();
        // $account_statuses = AccountStatus::orderBy('name','asc')->get();
        // $user_statuses = courtstatus::orderBy('name','asc')->get();
        // $province = Province::orderBy('name','asc')->get();
        // $cities = City::orderBy('name','asc')->get();
        // $areas = Area::orderBy('name','asc')->get();
        // $destinations = Area::orderBy('name','asc')->get();

        // return [
        //     'user'=>$user,
        //     'roles'=>$roles,
        //     'account_statuses'=>$account_statuses,
        //     'user_statuses'=>$user_statuses,
        //     'provinces'=>$province , 
        //     'cities'=>$cities,
        //     'areas' =>$areas,
        //     'destinations' =>$destinations
        //     ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $data = $request->all();
        $user = Court::find($id);

        $request->validate([
            'firstName' =>'required',
            'lastName' =>'required',
            'address' =>'required',
            'code' =>'required',
            'bi' =>'required',
            'mobile' =>'required|min:9',
            'cellphone' =>'required|min:9',
            'signature' =>'required',
            'area_id' =>'sometimes',
            'destination_id' =>'sometimes',
            'province_id' =>'required',
            'city_id' =>'required',
            'user_status_id' =>'required',
            'role_id' =>'sometimes',
            'account_status_id' =>'required',
            'email' =>'required|unique:courts,email,'.$user->id,
            'password' =>'sometimes|min:8',
        ]);

        

        $user->update([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'address' => $data['address'],
            'code' => $data['code'],
            'bi' => $data['bi'],
            'mobile' => $data['mobile'],
            'cellphone' => $data['cellphone'],
            'signature' => $data['signature'],
            'area_id' => request('area_id') ? $data['area_id'] : $user->area_id,
            'destination_id' => request('destination_id') ? $data['area_id'] :  $user->destination_id,
            'country_id' => 1,
            'province_id' => $data['province_id'],
            'city_id' => $data['city_id'],
            'user_status_id' => $data['user_status_id'],
            'role_id' => $data['role_id'],
            'account_status_id' => $data['account_status_id'],
            'email' => strtolower($data['email']),
            'password' => request('password') ? bcrypt($data['password']) : $user->password
        ]);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = Court::find($id);

        if(Auth::user()->id == $user->id){
            return abort(402,'Erro') ;
        }
        $user->delete();

        return response()->noContent();
    }
}
