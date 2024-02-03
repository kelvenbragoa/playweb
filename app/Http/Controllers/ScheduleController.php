<?php

namespace App\Http\Controllers;

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
        $searchQuery = request('query');

        $schedules = Schedule::query()
        ->when(request('query'),function($query,$searchQuery){
            $query->where('name','like',"%{$searchQuery}%");
        })
        ->orderBy('name','asc')
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
        $schedules = Schedule::create($data);
        return $schedules;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $schedule = Schedule::find($id);
        return [
            'schedule'=>$schedule,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $schedule = Schedule::find($id);
        
        return [
            'schedule'=>$schedule,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->all();
        $schedule = Schedule::find($id);
        $schedule->update($data);
        return $schedule;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $schedule = Schedule::find($id);
        $schedule->delete();
        return true;

    }
}
