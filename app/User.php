<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime','api_token'
    ];

    function getUserByEmail($email){
        $data=User::where('email', $email)->first();
        return $data;
    }

    function createNew($data){
        $save = User::newInstance($data);
        if($save->save()){
            return $save;
        }
    }

    function updateUserToken($user,$apiToken){
        $user->api_token=$apiToken;
        $user->save();
    }
}
