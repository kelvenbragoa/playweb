<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricesController extends Controller
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
        ->with('coin')
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
        $price = Price::create([
            'name'=>$data['name'],
            'price'=>$data['price'],
            'coin_id'=>1,
            'user_id'=>Auth::user()->id,
        ]);
        return $price;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $price = Price::with('coin')->find($id);
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

        $existince = Schedule::where('price_id',$id)->get();

        if($existince->count() > 0){
            return response()->json(
                [
             'message'=>'O preço não pode ser apagado porque está em uso'
            ],402);
        }else{
            $price->delete();
            return response()->noContent();
        }
        
    }
}
