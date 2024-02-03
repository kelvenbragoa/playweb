<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

        $price = Price::query()
        ->when(request('query'),function($query,$searchQuery){
            $query->where('name','like',"%{$searchQuery}%");
        })
        ->orderBy('name','asc')
        ->paginate();

        return $price;
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
        $price = Price::create($data);
        return $price;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $price = Price::find($id);
        return [
            'price'=>$price,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $price = Price::find($id);
        return [
            'price'=>$price,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->all();
        $price = Price::find($id);
        $price->update($data);
        return $price;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $price = Price::find($id);
        $price->delete();
        return true;
    }
}
