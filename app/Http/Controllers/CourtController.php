<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;

class CourtController extends Controller
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
            'limit' =>'required',
            'image_url' =>'required',
            'description' =>'required',
        ]);
        $court = Court::create($data);
        return $court;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $court = Court::find($id);
        return [
            'coin'=>$court,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $court = Court::find($id);
        return [
            'coin'=>$court,
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
        return $court;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $court = Court::find($id);
        $court->delete();
        return true;
    }
}
