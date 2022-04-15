<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Balance;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Str;

class AuthBasic extends Controller
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

    function login(Login $request){
        $User=new User();
        $email = $request->input('email');
        $password = $request->input('password');
        $user = $User->getUserByEmail($email);
        
        if(!empty($user)){
            if(Hash::check($password,$user->password)){
                $apiToken = hash('sha256', Str::random(60));
                $user = $User->updateUserToken($user,$apiToken);
                $this->data=['api_token'=>$apiToken];
                return $this->responseBase();
            }else{
                $this->code=200;
                $this->message = 'Password Salah';
                return $this->responseBase();
            }
        }else{
                $this->code=404;
                $this->message = 'User Not Found';
                return $this->responseBase();
        }
    }

    function register(Register $request){
        $Balance = new Balance();
        $User = new User();
        try {
            DB::beginTransaction();
            $userSave=$User->createNew([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $Balance->createNew([
                'user_id'=>$userSave->id,
                'amount_available'=>0
            ]);
            DB::commit();
            $this->code=201;
            $this->message = 'Data created';
            $this->data=['name'=>$request->name,'email'=>$request->email];
            
            return $this->responseBase();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->code=500;
            $this->message = 'Opps, error!!';
            return $this->responseBase();
        }
        

    }
}
