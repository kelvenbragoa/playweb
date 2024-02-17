<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Schedule;


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
    
            $schedule2 = Schedule::where('court_id',$data['court_id'])->with('court')->with('price')->with('status')->orderBy('date','desc')->paginate(200) ;
            return $schedule2;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    }
}
