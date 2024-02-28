<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PlayerController extends Controller
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
        $count = 0;

        
     
    
        $lotation =  Player::where('schedule_id',$data['schedule_id'])->count();
        $schedule = Schedule::find($data['schedule_id']);

        $schedule2 = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($data['schedule_id']);
        $playersData2 = Player::where('schedule_id',$data['schedule_id'])->with('user')->with('transaction')->paginate(200);

        if($lotation>=4){
            
            return response()->json([
                'message'=>'You have reached the limit of 4 players per schedule',
                'schedule' => $schedule2,
                'playersData'=>$playersData2
            ],400);
        }else{

            $schedule->update([
                'status_id'=>2
            ]);

            if($data['system'] == 2){

                // if($request->has('multipleschedule')){
            $this->addNextSchedule($data);
            
            $player = Player::create([
                'user_id'=>$data['user_id'],
                'schedule_id'=>$data['schedule_id'],
                'owner_id'=>$schedule->owner_id
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

            $user = User::find($data['user_id']);

            $transaction = Transaction::create([
                'user_id'=> $user->id,
                'type_transaction_id'=> 1,
                'amount'=> $schedule->price->price,
                'balance'=> $user->balance,
                'method'=> 'INTERNAL',
                'schedule_id'=>$schedule->id,
                'player_id'=>$player->id
            ]);
            Notification::send($user,new Operation('You joined the schedule : '.$schedule->date));

            $schedule = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($data['schedule_id']);
            $playersData = Player::where('schedule_id',$data['schedule_id'])->with('user')->with('transaction')->paginate(200);
            $nextschedules = Schedule::where('date',$schedule->date)->where('court_id',$schedule->court_id)->where('start_time','>',$schedule->start_time)->with('court')->with('price.coin')->with('status')->orderBy('start_time','asc')->take(2)->get();
    
            return response()->json([
                'schedule' => $schedule,
                'playersData'=>$playersData,
                'nextschedules'=>$nextschedules
            ],200);

            }else{

            $this->addNextLocalSchedule($data);

            $player = Player::create([
                'user_id'=>Auth::user()->id,
                'obs'=>'Usuário não registrado no sistema',
                'name'=>$data['name'],
                'mobile'=>$data['mobile'] ?? '',
                'email'=>$data['email'] ?? '',
                'schedule_id'=>$data['schedule_id'],
                'owner_id'=>$schedule->owner_id
            ]);
            $lotation =  Player::where('schedule_id',$data['schedule_id'])->count();
            if($lotation>=4){
                $schedule->update([
                  'status_id'=>3
                ]);
            }
            if($lotation==1){
                $schedule->update([
                  'user_id'=>Auth::user()->id
                ]);
            }

            $user = User::find(Auth::user()->id);

            $transaction = Transaction::create([
                'user_id'=> $user->id,
                'type_transaction_id'=> 1,
                'amount'=> $schedule->price->price,
                // 'balance'=> $user->balance-$schedule->price->price,
                'balance'=> $user->balance,
                'method'=> 'INTERNAL',
                'schedule_id'=>$schedule->id,
                'player_id'=>$player->id
            ]);
            

            Notification::send($user,new Operation('You joined the schedule : '.$schedule->date));

            $schedule = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($data['schedule_id']);
            $playersData = Player::where('schedule_id',$data['schedule_id'])->with('user')->with('transaction')->paginate(200);
            $nextschedules = Schedule::where('date',$schedule->date)->where('court_id',$schedule->court_id)->where('start_time','>',$schedule->start_time)->with('court')->with('price.coin')->with('status')->orderBy('start_time','asc')->take(2)->get();
            
            return response()->json([
                'schedule' => $schedule,
                'playersData'=>$playersData,
                'nextschedules'=>$nextschedules
            ],200);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $player = Player::findOrFail($id);
        $schedule = Schedule::with('court')->with('price.coin')->with('status')->findOrFail($player->schedule_id);
        $transation = Transaction::where('player_id', $player->id)->first();
        
        $player->delete();
        $transation->delete();
        $lotation =  Player::where('schedule_id',$player->schedule_id)->count();
        $playersData = Player::where('schedule_id',$player->schedule_id)->with('user')->with('transaction')->paginate(200);
        $nextschedules = Schedule::where('date',$schedule->date)->where('court_id',$schedule->court_id)->where('start_time','>',$schedule->start_time)->with('court')->with('price.coin')->with('status')->orderBy('start_time','asc')->take(2)->get();

        if($lotation == 0){
            $schedule->update([
              'status_id'=>1
            ]);
        }
        return response()->json([
          'message'=>'Agendamento apagado.',
          'schedule'=>$schedule,
          'playersData'=>$playersData,
          'nextschedules'=>$nextschedules
        ],200);
    }

    public function addNextLocalSchedule($data){
        
        foreach($data['multipleschedule'] as $item){
            if(count($item) > 0){
                $lotation =  Player::where('schedule_id',$item['multipleschedule_id'])->count();
                $schedule = Schedule::find($item['multipleschedule_id']);
                $schedule->update([
                    'status_id'=>2
                ]);

                if($lotation<4){
                    $player = Player::create([
                    'user_id'=>Auth::user()->id,
                    'obs'=>'Usuário não registrado no sistema',
                    'name'=>$data['name'],
                    'mobile'=>$data['mobile'] ?? '',
                    'email'=>$data['email'] ?? '',
                    'schedule_id'=>$item['multipleschedule_id'],
                    'owner_id'=>$schedule->owner_id
                ]);
                $lotation =  Player::where('schedule_id',$item['multipleschedule_id'])->count();
                if($lotation>=4){
                    $schedule->update([
                    'status_id'=>3
                    ]);
                }
                if($lotation==1){
                    $schedule->update([
                    'user_id'=>Auth::user()->id
                    ]);
                }

                $user = User::find(Auth::user()->id);

                $transaction = Transaction::create([
                    'user_id'=> $user->id,
                    'type_transaction_id'=> 1,
                    'amount'=> $schedule->price->price,
                    // 'balance'=> $user->balance-$schedule->price->price,
                    'balance'=> $user->balance,
                    'method'=> 'INTERNAL',
                    'schedule_id'=>$schedule->id,
                    'player_id'=>$player->id
                ]);
                Notification::send($user,new Operation('You joined the schedule : '.$schedule->date));
            }
            }
        }
    }

    public function addNextSchedule($data){
        
        foreach($data['multipleschedule'] as $item){
            if(count($item) > 0){

                $lotation =  Player::where('schedule_id',$item['multipleschedule_id'])->count();
                $schedule = Schedule::find($item['multipleschedule_id']);
                $schedule->update([
                    'status_id'=>2
                ]);

                $player = Player::create([
                    'user_id'=>$data['user_id'],
                    'schedule_id'=>$item['multipleschedule_id'],
                    'owner_id'=>$schedule->owner_id
                ]);
                $lotation =  Player::where('schedule_id',$item['multipleschedule_id'])->count();
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
    
                $user = User::find($data['user_id']);
    
                $transaction = Transaction::create([
                    'user_id'=> $user->id,
                    'type_transaction_id'=> 1,
                    'amount'=> $schedule->price->price,
                    'balance'=> $user->balance,
                    'method'=> 'INTERNAL',
                    'schedule_id'=>$schedule->id,
                    'player_id'=>$player->id
                ]);
                Notification::send($user,new Operation('You joined the schedule : '.$schedule->date));
              
            
            }
        }
    }
}
