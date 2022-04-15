<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = "transaction";
	protected $primaryKey = 'id';
	public $incrementing = true;
    protected $guarded = [
        'created_at', 'updated_at',
    ];

    protected $fillable = [
        'id',
        'trx_id',
        'user_id',
        'amount',
    ];

    function createNew($data){
        $save = Transaction::newInstance($data);
        if($save->save()){
            return $save;
        }
    }
}
