<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Random extends Controller
{
    //
    private $url='';
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

    function quote(){
        return $this->chuck();
    }

    function chuck(){
        try {
            $this->url='https://api.chucknorris.io/jokes/random';
            $get =  $this->getData();
            $this->data = [
                'type'=>'joke',
                'value'=>$get->value,
            ];
            return $this->responseBase();
        } catch (\Exception $th) {
            $this->code=500;
            $this->message = 'Opps, error!!';
            $this->data=$th;
            return $this->responseBase();
        }
        
    }

    function dog(){
        try {
            $this->url='https://dog-facts-api.herokuapp.com/api/v1/resources/dogs?number=1';
            $get =  $this->getData();
            $this->data = [
                'type'=>'fact',
                'value'=>$get[0]->fact
            ];
            return $this->responseBase();
        } catch (\Throwable $th) {
            $this->code=500;
            $this->message = 'Opps, error!!';
            $this->data=$th;
            return $this->responseBase();
        }
        
    }

    function cat(){
        try {
            $this->url='https://catfact.ninja/fact';
            $get =  $this->getData();
            $this->data = [
                'type'=>'fact',
                'value'=>$get->fact
            ];
            return $this->responseBase();
        } catch (\Exception $th) {
            $this->code=500;
            $this->message = 'Opps, error!!';
            $this->data=$th;
            return $this->responseBase();
        }
        
    }

    function getData(){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST =>0,
        CURLOPT_SSL_VERIFYPEER=>0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}
