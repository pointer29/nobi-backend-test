<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $table = "history";
	protected $primaryKey = 'id';
	public $incrementing = false;
    protected $guarded = [
        'created_at', 'updated_at',
    ];

    protected $fillable = [
        'id',
        'name',
        'ticker',
        'coin_id',
        'code',
        'exchange',
        'invalid',
        'record_time',
        'usd',
        'idr',
        'hnst',
        'eth',
        'btc',
        'created_at',
        'updated_at',
    ];

    function findMin($checkDate,$sort){
        if($checkDate['currency']=='idr'){
            $currency='idr';
        }else{
            $currency='usd';
        }
        $data= History::whereBetween('created_at',[$checkDate['week_start'],$checkDate['week_end']])
        ->where('ticker',$checkDate['ticker'])
        ->orderBy($currency, $sort)
        ->first();
        return $data;
    }

    function getHistory($request){
        if($request->currency=='idr'){
            $data= History::whereBetween('created_at',[$request->starttime,$request->endtime])
            ->where('ticker',$request->ticker)
            ->select('created_at as datetime','idr as price')
            ->get();
            
        }else{
            $data= History::whereBetween('created_at',[$request->starttime,$request->endtime])
            ->where('ticker',$request->ticker)
            ->select('created_at as datetime','usd as price')
            ->get();
        }
        return $data;
    }
}
