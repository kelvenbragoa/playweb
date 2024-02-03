<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

        $status = Status::query()
        ->when(request('query'),function($query,$searchQuery){
            $query->where('name','like',"%{$searchQuery}%");
        })
        ->orderBy('name','asc')
        ->paginate();

        return $status;
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
            'color' =>'required',
        ]);
        $status = Status::create($data);
        return $status;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $status = Status::find($id);
        return [
            'status'=>$status,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $status = Status::find($id);
        
        return [
            'status'=>$status,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->all();
        $status = Status::find($id);
        $status->update($data);
        return $status;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $status = Status::find($id);
        $status->delete();
        return true;

    }
}
