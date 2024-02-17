<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Price;
use App\Models\Schedule;
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
            ->where('owner_id',Auth::user()->id)
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
            'name' =>'required',
            'description' =>'required',
            'image_url' =>'required',
            


            
        ]);

        // dd(Auth::user()->club->id);

        $court = Court::create([
            'name'=>$data['name'],
            'image_url'=>$data['image_url'],
            'club_id'=>Auth::user()->club->id,
            'owner_id'=>Auth::user()->id,
            'description'=>$data['description'],
            'limit'=>4
        ]);

        return $court;

       
           
          
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $court = Court::
        find($id);
        $schedule = Schedule::where('court_id',$id)->with('court')->with('price')->with('status')->orderBy('date','desc')->paginate(200) ;
        $prices = Price::all();

        return [
            'court'=>$court,
            'schedule'=>$schedule,
            'prices'=>$prices
        
        ];
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
