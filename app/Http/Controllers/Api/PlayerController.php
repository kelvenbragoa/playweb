<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PlayerController extends Controller
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
        $lotation =  Player::where('schedule_id',$data['schedule_id'])->count();
        $schedule = Schedule::find($data['schedule_id']);

        if($lotation>=4){
            return response()->json([
             'status'=>400,
             'message'=>'You have reached the limit of 4 players per schedule'
            ]);
        }else{
            $schedule->update([
                'status_id'=>2
            ]);
            $player = Player::create($data);
            $lotation =  Player::where('schedule_id',$data['schedule_id'])->count();
            if($lotation>=4){
                $schedule->update([
                  'status_id'=>3
                ]);
            }
            if($lotation==1){
                $schedule->update([
                  'user_id'=>$data['user_id']
                ]);
            }
            return response()->json([
                'status'=>200,
                'message'=>'You joined the schedule'
               ]);
        }
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


    public function myschedule(string $id){
        
        $players = Player::where('user_id',$id)->with('schedule.court')->get();
        return response()->json([
          'status'=>200,
            'players'=>$players
        ]);
    }
}
