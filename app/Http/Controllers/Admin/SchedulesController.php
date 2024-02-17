<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

            $schedules = Schedule::query()
            ->when(request('query'),function($query,$searchQuery){
                $query->where('date','like',"%{$searchQuery}%");
            })
            ->with('status')
            ->with('court')
            ->with('players')
            ->with('price')
            ->orderBy('id','desc')
            ->paginate();


            return $schedules;
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
            'date' =>'required',
            'start_time' =>'required',
            'end_time' =>'required',
            'price_id' =>'required',
            'court_id' =>'required',
          
        ]);

        $court = Court::find($data['court_id']);
        $test1 = Schedule::where('court_id',$data['court_id'])->where('date',$data['date'])->where('start_time',$data['start_time'])->count();
        $test2 = Schedule::where('court_id',$data['court_id'])->where('date',$data['date'])->where('end_time',$data['end_time'])->count();

        if($test1>0|| $test2>0){
            return response()->json(
                ['message'=>'Existe um agendamento com este horario ja cadasatrado'],
                401
            );
        }

        
            $schedule = Schedule::create([
                'date' => $data['date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'price_id' => $data['price_id'],
                'court_id' => $data['court_id'],
                'status_id' => 1,
                'owner_id'=>$court->owner_id
            ]);
    
            return $schedule;
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $schedule = Schedule::
        with('status')
        ->with('court')
        ->with('players')
        ->with('price')
       ->find($id);

        return $schedule;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // $schedule = Schedule::find($id);
        // $roles = Role::orderBy('name','asc')->get();
        // $account_statuses = AccountStatus::orderBy('name','asc')->get();
        // $schedule_statuses = schedulestatus::orderBy('name','asc')->get();
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
        $schedule = Schedule::find($id);

      

        

        $schedule->update([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'address' => $data['address'],
            'code' => $data['code'],
            'bi' => $data['bi'],
            'mobile' => $data['mobile'],
            'cellphone' => $data['cellphone'],
            'signature' => $data['signature'],
            'area_id' => request('area_id') ? $data['area_id'] : $schedule->area_id,
            'destination_id' => request('destination_id') ? $data['area_id'] :  $schedule->destination_id,
            'country_id' => 1,
            'province_id' => $data['province_id'],
            'city_id' => $data['city_id'],
            'user_status_id' => $data['user_status_id'],
            'role_id' => $data['role_id'],
            'account_status_id' => $data['account_status_id'],
            'email' => strtolower($data['email']),
            'password' => request('password') ? bcrypt($data['password']) : $schedule->password
        ]);

        return $schedule;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $schedule = Schedule::find($id);

        if(Auth::user()->id == $schedule->id){
            return abort(402,'Erro') ;
        }
        $schedule->delete();

        return response()->noContent();
    }
}
