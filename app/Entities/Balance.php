<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    //
    protected $table = "balance";
	protected $primaryKey = 'id';
	public $incrementing = true;
    protected $guarded = [
        'created_at', 'updated_at',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'amount_available',
    ];

    function createNew($data){
        $save = Balance::newInstance($data);
        if($save->save()){
            return $save;
        }
    }

    function findBalanceWithUser($user_id){
        return Balance::where('user_id',$user_id)->find();
    }

    function updateBalance($find, $update){
        $find->amount_available = $update['amount_available'];
        if($find->save()){
            return $find;
        }
    }
}
