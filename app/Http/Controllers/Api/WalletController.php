<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        return response()->json(
            [
                'message'=>'Success',
                'wallet'=>$user
            ],
            200
        );
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

    public function mpesa(Request $request){
        $data = $request->all();
        $request->validate([
            'amount' => ['required','numeric'],
            'mobile' => ['required','numeric'],
        ]);

        $user = User::find($data['user_id']);

        $amount = $data['amount'];
        $msisdn = $data['mobile'];

        $config = \abdulmueid\mpesa\Config::loadFromFile('config.php');
        $transactionmpesa = new \abdulmueid\mpesa\Transaction($config);

        $reference = Transaction::count();
        $string = substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(3/strlen($x)) )),1,3);
        $ref = 'PADEL'.$string.$reference+1;

        // if($user->balance<$amount){
        //     return response()->json(
        //         [
        //             'message'=>'Saldo insuficiente',
        //         ],
        //         401
        //     );
        // }
     

        $c2b = $transactionmpesa->c2b(
            1, //valor a cobrar do cliente
            $msisdn, // número de telefone do cliente vodacom com mpesa registrado
            $ref, //referencia do pagamento
            $ref //referencia do pagamento
        );

        

        if($c2b->getCode() === 'INS-0') { //codigo de sucesso de pagamento

            $transaction = Transaction::create([
                'user_id'=> $data['user_id'],
                'type_transaction_id'=> 2,
                'amount'=> $data['amount'],
                'balance'=> $user->balance+$data['amount'],
                'method'=> 'Mpesa',
            ]);
            $user->update([
                'balance'=> $user->balance+$data['amount'],
            ]);

            $modelTransaction = Transaction::with('user')->with('transaction')->find($transaction->id);
            
            return response()->json(
                [
                    'message'=>'success',
                    'transaction'=> $modelTransaction
                ],
                200
            );
            
        }
        if($c2b->getCode() === 'INS-1') {

            
            return response()->json(
                [
                    'message'=>'Erro interno, volte a tentar novamente',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-2') {
            //API INVALIDA
              
            return response()->json(
                [
                    'message'=>'Erro interno, volte a tentar novamente',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-4') {
            //API INVALIDA, USUARIO NAO ATIVO
              
            return response()->json(
                [
                    'message'=>'messageError', 'Erro interno, volte a tentar novamente',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-5') {
            //API INVALIDA, USUARIO CANCELOU
              
            return response()->json(
                [
                    'message'=>'Transação cancelado pelo usuário',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-6') {
            //API INVALIDA, Transaçãp falhou
              
            return response()->json(
                [
                    'message'=>'Transação falhou',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-9') {
            //API INVALIDA, REQUEST TIMEOUT
              
            return response()->json(
                [
                    'message'=>'O tempo expirou. Volte a tentar',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-10') {
                      
            return response()->json(
                [
                    'message'=>'Transação duplicada',
                    
                ],
                401
            );

        }
        if($c2b->getCode() === 'INS-16') {
        
            
              
            return response()->json(
                [
                    'message'=>'Erro interno volte mais tarde',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-2006') {
        
           
              
            return response()->json(
                [
                    'message'=>'Saldo insuficiente',
                    
                ],
                401
            );

        }

        if($c2b->getCode() === 'INS-2051') {
        
           
              
            return response()->json(
                [
                    'message'=>'Número de telefone inválido',
                    
                ],
                401
            );

        }

        
    }

    public function emola(Request $request){
        $data = $request->all();

    }

    public function visa(Request $request){
        $data = $request->all();

    }

    public function transaction($id){
        $transactions = Transaction::with('transaction')->with('user')->where('user_id',$id)->orderBy('id','desc')->get();

        return response()->json(
            [
                'message'=>'success',
                'transactions'=>$transactions
            ],200
        );

    }
}
