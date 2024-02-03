<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

        $coins = Coin::query()
        ->when(request('query'),function($query,$searchQuery){
            $query->where('name','like',"%{$searchQuery}%");
        })
        ->orderBy('name','asc')
        ->paginate();

        return $coins;
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
            'symbol' =>'required',
        ]);
        $coin = Coin::create($data);
        return $coin;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $coin = Coin::find($id);
        return [
            'coin'=>$coin,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $coin = Coin::find($id);
        return [
            'coin'=>$coin,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->all();
        $coin = Coin::find($id);
        $coin->update($data);
        return $coin;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $coin = Coin::find($id);
        $coin->delete();
        return true;
    }
}
