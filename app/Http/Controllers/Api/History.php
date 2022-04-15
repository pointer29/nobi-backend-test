<?php

namespace App\Http\Controllers\Api;

use App\Entities\History as EntitiesHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\History as RequestsHistory;
use App\Http\Requests\LowHigh;
use App\Http\Requests\Upload;
use App\Imports\HistoryImport;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class History extends Controller
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

    function upload(Upload $request){

        $HistoryImport = new HistoryImport;
        try {
            // DB::beginTransaction();
            Excel::import($HistoryImport, request()->file('file'));
            $this->message = 'success!';
            $this->code=201;
            return $this->responseBase();
            // DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            // DB::rollback();
            $this->code=500;
            $this->message = 'error during upload, maybe data already exist!';
            return $this->responseBase();
        }
    }

    function lowhigh(LowHigh $request){
        $History = new EntitiesHistory();
        $dataArray=$this->getStartAndEndDate($request->week,$request->year);
        $dataArray['ticker']=$request->ticker;
        $dataArray['currency']=$request->currency;
        $findMin=$History->findMin($dataArray,'ASC');
        $findMax=$History->findMin($dataArray,'DESC');
        if($dataArray['currency']=='idr'){
            $min=$findMin->idr;
            $max=$findMax->idr;
            $pair='idr';
        }else{
            $min=$findMin->usd;
            $max=$findMax->usd;
            $pair='usd';
        }
        $arrayResponse = [
            'min'=>$min,
            'max'=>$max,
            'week'=>$request->week,
            'year'=>$request->year,
            'pair'=>$request->pair,
        ];
        $this->message = 'Success!';
        $this->data=$arrayResponse;
        return $this->responseBase();
        
    }

    function history(RequestsHistory $request){
        $History = new EntitiesHistory();
        $getHistory = $History->getHistory($request);
        $this->message = 'Success!';
        $this->data=$getHistory;
        return $this->responseBase();
    }

    function getStartAndEndDate($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
      }
    
}
