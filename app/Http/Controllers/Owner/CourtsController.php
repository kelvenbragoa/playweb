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
        $schedule = Schedule::where('court_id',$id)->with('court')->with('price.coin')->with('status')->where('date',date('Y-m-d'))->orderBy('start_time','asc')->paginate(200) ;
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
        $court = Court::
        find($id);
        $schedule = Schedule::where('court_id',$id)->with('court')->with('price.coin')->with('status')->orderBy('date','desc')->paginate(200) ;
        $prices = Price::all();

        return [
            'court'=>$court,
            'schedule'=>$schedule,
            'prices'=>$prices
        
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $data = $request->all();
        $court = Court::find($id);

        $court->update($data);



       

        return response()->json([
            'court'=>$court
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $court = Court::find($id);

        $schedules = Schedule::where('court_id',$id)->get();

        if($schedules->count() > 0){
            return response()->json(
                [
            'message'=>'O court não pode ser apagado porque está em uso'
            ],402);
        }

        $court->delete();

        return response()->noContent();
    }

    public function updatecourtschedule($date,$id){
        

        $court = Court::
        find($id);
        $schedule = Schedule::where('court_id',$id)->with('court')->with('price.coin')->with('status')->where('date',$date)->orderBy('start_time','asc')->paginate(200);
        $prices = Price::all();

        return [
            'court'=>$court,
            'schedule'=>$schedule,
            'prices'=>$prices
        
        ];

        
    }
}
