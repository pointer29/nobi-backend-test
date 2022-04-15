<?php

namespace App\Imports;

use App\Entities\History;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HistoryImport implements ToModel,WithStartRow,WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function model(array $row)
    {
        return new History([
            'id'=>$row[0],
            'name'=>$row[1],
            'ticker'=>$row[2],
            'coin_id'=>$row[3],
            'code'=>$row[4],
            'exchange'=>$row[5],
            'invalid'=>$row[6],
            'record_time'=>$row[7],
            'usd'=>$row[8],
            'idr'=>$row[9],
            'hnst'=>$row[10],
            'eth'=>$row[11],
            'btc'=>$row[12],
            'created_at'=>$row[13],
            'updated_at'=>$row[14],
        ]);
    }
}
