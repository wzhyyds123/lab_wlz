<?php

namespace App\import;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class UsersImport implements ToCollection
{
    /**
     * 使用 ToCollection
     * @param array $row
     *
     * @
     */
    public function collection(Collection $rows)
    {
        $login_id = auth('api')->user()->id;
        foreach ($rows as $key => $value)
        {
            $created_at = now();
            $updated_at = now();
            DB::table('program')->insert([
                //  'id'=> $value[0],
                'prname'=>$value[0],
                //    'prclass'=>$value[1],
                'prnumber'=>$value[1],
                'created_at'=>$created_at,
                'updated_at'=>$updated_at,
                'login_id' =>$login_id,
            ]);
        }
    }
    public function createData($rows)
    {
        //todo
    }
}
