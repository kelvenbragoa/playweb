<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dateQuery = request('date');
        $idQuery = request('id');

        // $courts = Schedule::query()
        // ->when(request('query'),function($query,$searchQuery){
        //     $data = date('Y-m-d',strtotime($searchQuery));
        //     $query->where('name','like',"%{$searchQuery}%");
        // })
        // ->orderBy('name','asc')
        // ->get();

        $schedules = Schedule::with('status')->with('price')->with('court')->where('court_id',$idQuery)->where('date',$dateQuery)->orderBy('start_time','asc')->get();

        return ['schedules'=>$schedules];
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $schedule = Schedule::with('status')->with('price')->with('court')->find($id);
        $lotation =  Player::where('schedule_id',$id)->count();
        $schedule->players=$lotation;
        


        return ['schedule'=>[$schedule]];
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
