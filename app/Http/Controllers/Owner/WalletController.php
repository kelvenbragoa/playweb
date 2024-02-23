<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Recharge;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $searchQuery = request('query');

        $recharge = Recharge::query()
        ->when(request('query'),function($query,$searchQuery){
            $query->where('amount','like',"%{$searchQuery}%");
        })
        ->with('user')
        ->where('owner_id',Auth::user()->id)
        ->orderBy('id','desc')
        ->paginate();

        return $recharge;
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
        $club = Club::where('user_id',Auth::user()->id)->with('province')->first();
        $recharge = Recharge::create([
            'user_id'=>$data['user_id'],
            'ref'=>$data['ref'],
            'method'=>$data['method'],
            'price'=>$data['price'],
            'club_id'=>$club->id,
            'owner_id'=>Auth::user()->id,
        ]);

        $user = User::find($data['user_id']);

        $user->update([
            'balance'=>$user->balance + $data['price']
        ]);

       
        return $recharge;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $recharge = Recharge::with('user')->find($id);
        return [
            'recharge'=>$recharge,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $recharge = Recharge::find($id);

        return [
            'recharge'=>$recharge,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->all();
        $recharge = Recharge::find($id);
        $recharge->update($data);
        return $recharge;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $recharge = Recharge::find($id);

        $existince = Schedule::where('price_id',$id)->get();

        if($existince->count() > 0){
            return response()->json(
                [
             'message'=>'O preço não pode ser apagado porque está em uso'
            ],402);
        }else{
            $recharge->delete();
            return response()->noContent();
        }
        
    }
}
