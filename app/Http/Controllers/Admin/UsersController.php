<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

            $users = User::query()
            ->when(request('query'),function($query,$searchQuery){
                $query->where('name','like',"%{$searchQuery}%")->orWhere('surname','like',"%{$searchQuery}%")->orWhere('email','like',"%{$searchQuery}%");
            })
            ->with('role')
            ->orderBy('name','asc')
            ->paginate();


            return $users;
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
            'name' =>'required',
            'surname' =>'required',
            'mobile' =>'required',
            'birth_date' =>'required',
            'gender_id' =>'required',
            'club_name' =>'required|min:9',
            'image_url' =>'required|min:9',
            'province_id' =>'required',
            'address' =>'required',
            'description' =>'required',
            'min_price' =>'required',
            'email' =>'required|unique:users,email',
            'password' =>'required|min:8',
        ]);

        $user = User::create([
            'name' =>$data['name'],
            'surname' =>$data['surname'],
            'mobile' =>$data['mobile'],
            'birth_date' =>$data['birth_date'],
            'gender_id' =>$data['gender_id'],
            'balance' =>0,
            'role_id' =>2,
            'email' =>$data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $club = Club::create([
            'name' =>$data['club_name'],
            'image_url' =>$data['image_url'],
            'address' =>$data['address'],
            'user_id' =>$user->id,
            'province_id' =>$data['province_id'],
            'description' =>$data['description'],
            'min_price' =>$data['min_price'],
            'is_active' =>1,
        ]);

        
    
        return $user;
        



        



        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $user = User::with('role')
       ->find($id);

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // $user = User::find($id);
        // $roles = Role::orderBy('name','asc')->get();
        // $account_statuses = AccountStatus::orderBy('name','asc')->get();
        // $user_statuses = UserStatus::orderBy('name','asc')->get();
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
        $user = User::find($id);

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
            'email' =>'required|unique:users,email,'.$user->id,
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
        $user = User::find($id);

        if(Auth::user()->id == $user->id){
            return abort(402,'Erro') ;
        }
        $user->delete();

        return response()->noContent();
    }
}
