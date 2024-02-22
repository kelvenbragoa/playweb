<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\Operation;
use Illuminate\Support\Facades\Notification;

class ScheduleController extends Controller
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
            ],400);
        }else{
            $schedule->update([
                'status_id'=>2
            ]);
            
            $player = Player::create([
                'user_id'=>$data['user_id'],
                'schedule_id'=>$data['schedule_id'],

            ]);
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

            $player2 = Player::
            with('schedule')
            ->with('schedule.court.club')
            ->with('schedule.price')
            ->with('user')
            ->find($player->id);

            $user = User::find($data['user_id']);

            // $user->update([
            //     'balance'=>$user->balance - $schedule->price->price
            // ]);

            $transaction = Transaction::create([
                'user_id'=> $user->id,
                'type_transaction_id'=> 1,
                'amount'=> $schedule->price->price,
                'balance'=> $user->balance-$schedule->price->price,
                'method'=> 'INTERNAL',
                'schedule_id'=>$schedule->id,
                'player_id'=>$player->id
            ]);
            Notification::send($user,new Operation('You joined the schedule : '.$schedule->date));

            $schedule = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($data['schedule_id']);
            $playersData = Player::where('schedule_id',$data['schedule_id'])->with('user')->with('transaction')->paginate(200);

            return response()->json([
                'schedule' => $schedule,
                'playersData'=>$playersData
            ],200);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $schedule = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($id);
        $playersData = Player::where('schedule_id',$id)->with('user')->with('transaction')->paginate(200);

        return response()->json([
            'schedule' => $schedule,
            'playersData'=>$playersData
        ],200);
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

    public function searchusers(){
        $searchQuery = request('query');
        $users = User::query()
            ->when(request('query'),function($query,$searchQuery){
                $query->where('name','like',"%{$searchQuery}%")
                ->orWhere('surname','like',"%{$searchQuery}%")
                ->orWhere('mobile','like',"%{$searchQuery}%")
                ->orWhere('email','like',"%{$searchQuery}%")
                
                ;
            })
            
            ->orderBy('name','asc')
            ->get();


            return $users;
    }
}
