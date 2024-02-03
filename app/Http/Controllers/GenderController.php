<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

        $genders = Gender::query()
        ->when(request('query'),function($query,$searchQuery){
            $query->where('name','like',"%{$searchQuery}%");
        })
        ->orderBy('name','asc')
        ->paginate();

        return $genders;
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
        ]);
        $gender = Gender::create($data);
        return $gender;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $gender = Gender::find($id);
        return [
            'gender'=>$gender,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $gender = Gender::find($id);
        return [
            'gender'=>$gender,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->all();
        $gender = Gender::find($id);
        $gender->update($data);
        return $gender;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $gender = Gender::find($id);
        $gender->delete();
        return true;
    }
}
