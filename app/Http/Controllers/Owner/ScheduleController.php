<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Player;
use App\Models\Price;
use App\Models\Schedule;
use App\Models\User;
use Carbon\CarbonPeriod;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    
            $schedule2 = Schedule::where('court_id',$data['court_id'])->with('court')->with('price.coin')->with('status')->where('date',$data['date'])->orderBy('date','desc')->paginate(200) ;
            return $schedule2;
    }

    /**
     * Display t
     * he specified resource.
     */
    
    public function show(string $id)
    {
        //
        $schedule = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($id);
        $playersData = Player::where('schedule_id',$id)->with('user')->with('transaction')->paginate(200);

        return response()->json([
            'schedule' => $schedule,
            'playersData'=>$playersData
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $schedule = Schedule::find($id);

        $players = Player::where('schedule_id',$id)->get();

        if($players->count() > 0){
            return response()->json(
                [
            'message'=>'O court não pode ser apagado porque está em uso'
            ],402);
        }

        $schedule->delete();

        return response()->noContent();
    }

    public function searchusers(){
        $searchQuery = request('query');
        $users = User::query()
            ->when(request('query'),function($query,$searchQuery){
                $query->where('name','like',"%{$searchQuery}%")
                ->orWhere('surname','like',"%{$searchQuery}%")
                ->orWhere('mobile','like',"%{$searchQuery}%")
                ->orWhere('email','like',"%{$searchQuery}%")
                
                ;
            })
            
            ->orderBy('name','asc')
            ->get();


            return $users;
    }

    public function copy (Request $request){
        $data = $request->all();
        $date = date('Y-m-d',strtotime($data['date']));
        $period = CarbonPeriod::create($data['start_date'], $data['end_date']);

        $schedule = Schedule::where('date',$date)->where('court_id',$data['court_id'])->orderBy('start_time','asc')->get();

        
        $arraydate = [];

            foreach ($period as $key => $date) {
                // $arraydate[] =($date->format('Y-m-d'));
                foreach($schedule as $item){

                    $test1 = Schedule::where('court_id',$data['court_id'])->where('date',$date->format('Y-m-d'))->where('start_time',$item->start_time)->count();
                    $test2 = Schedule::where('court_id',$data['court_id'])->where('date',$date->format('Y-m-d'))->where('end_time',$item->end_time)->count();

                    if($test1>0|| $test2>0){
                        
                    }else{
                        Schedule::create([
                            'date' => $date->format('Y-m-d'),
                            'start_time' => $item->start_time,
                            'end_time' => $item->end_time,
                            'price_id' => $item->price_id,
                            'court_id' => $item->court_id,
                            'status_id' => 1,
                            'owner_id'=>$item->owner_id
                        ]);
                    }
                }

                
            }


            $court = Court::
            find($data['court_id']);
            $schedule = Schedule::where('court_id',$data['court_id'])->with('court')->with('price.coin')->with('status')->where('date',date('Y-m-d'))->orderBy('start_time','asc')->paginate(200) ;
            $prices = Price::all();
    
            return [
                'court'=>$court,
                'schedule'=>$schedule,
                'prices'=>$prices
            
            ];
        
    }

    public function generate (Request $request){

        $data = $request->all();
        $date = date('Y-m-d',strtotime($data['date']));
        $period = CarbonPeriod::create($data['start_time'],$data['step'].' minutes' ,$data['end_time']);  
        $court = Court::find($data['court_id']);
        $arraydate = [];

        


        foreach ($period as $key => $time) {
            $arraydate[] =($time->format('H:i'));
        } 

        // dd($arraydate);

        $length = count($arraydate);

        // dd($length);

        for($i = 0; $i < $length - 1; ++$i) {
            if (current($arraydate) === next($arraydate)) {
                // they match
            }

            // dd($arraydate[$i], $arraydate[$i+1]);
            $test1 = Schedule::where('court_id',$data['court_id'])->where('date',$date)->where('start_time',$arraydate[$i])->count();
            $test2 = Schedule::where('court_id',$data['court_id'])->where('date',$date)->where('end_time',$arraydate[$i+1])->count();

            if($test1>0|| $test2>0){
                
            }else{
                Schedule::create([
                    'date' => $date,
                    'start_time' => $arraydate[$i],
                    'end_time' =>$arraydate[$i+1],
                    'price_id' => $data['price_id'],
                    'court_id' => $court->id,
                    'status_id' => 1,
                    'owner_id'=>$court->owner_id
                ]);
            }
        }

        $schedule = Schedule::where('court_id',$data['court_id'])->with('court')->with('price.coin')->with('status')->where('date',date('Y-m-d'))->orderBy('start_time','asc')->paginate(200) ;
        $prices = Price::all();
    
            return [
                'court'=>$court,
                'schedule'=>$schedule,
                'prices'=>$prices
            
            ];

        

    }
}
