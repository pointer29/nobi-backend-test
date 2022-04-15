<?php

namespace App\Http\Controllers\Api;

use App\Entities\Balance;
use App\Entities\Transaction as EntitiesTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction as RequestsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Str;

class Transaction extends Controller
{
    //
    private $message='';
    private $code = 200;
    private $data = [];

    function responseBase(){
        return response()->json([
                'message'=>$this->message,
                'status'=>$this->code,
                'data'=>$this->data
        ],$this->code);
    }

    function transaction(RequestsTransaction $request){
        // $User = Auth::User();
        $Balance = new Balance();
        $Transaction = new EntitiesTransaction();
        $findBalance = $Balance->findBalanceWithUser($request->user_id);
        if(empty($findBalance)){
            $this->message='Empty balance';
            $this->code=404;
            return $this->responseBase();
        }

        // dd($findBalance->amount_available,$request->amount);
        if($findBalance->amount_available<$request->amount){
            $this->message='Insufficient balance';
            return $this->responseBase();
        }

        $findTrx = $Transaction->checkTrxId($request->trx_id);
        if(!empty($findTrx)){
            $this->message='Trxid exist! please using another trx_id.';
            return $this->responseBase();
        }

        try {
            DB::beginTransaction();
            $transactionInsert = [
                'trx_id'=> $request->trx_id,
                'user_id'=> $request->user_id,
                'amount'=> $request->amount
            ];
    
            $inputTransaction = $Transaction->createNew($transactionInsert);
    
            $balanceArray = [
                'amount_available'=>$findBalance->amount_available-$request->amount
            ];
    
            $updateBalance= $Balance->updateBalance($findBalance,$balanceArray);
    
            $this->message='Transaksi Sukses!';
            $this->code=201;
            $this->data = [
                'trx_id'=>$inputTransaction->trx_id,
                'balance'=>bcdiv($updateBalance->amount_available, 1, 6)
            ];
            DB::commit();
            // sleep(30); // sleep 30 second ?
            return $this->responseBase();
        } catch (\Exception $th) {
            // throw $th;
            DB::rollback();
            $this->code=500;
            $this->message = 'Opps, error!!';
            return $this->responseBase();
        }
        
        
    }
}
