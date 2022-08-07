<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class information extends Model
{
   protected $table = "information";
   public $timestamps = true;
   protected $primaryKey = "id";
   protected $guarded = [];

   /**
    * 查询数据集信息
    */

   public static function Wzh_Find($age){
       try {
           $date = self::select('name','created_at')->where('age','=',$age)->get();
           return $date;
       }catch(\Exception $e){
        logError('操作失败',[$e->getMessage()]);
        return false;
       }
   }
}
