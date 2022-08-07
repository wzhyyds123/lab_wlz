<?php

namespace App\Http\Controllers;

use App\Model\information;
use Illuminate\Http\Request;

class TestController extends Controller
{
/**
 *  查询数据库数据（测试）
 */
    public function WzhFind(Request $request){
    $age = $request['age'];   //与用于表单数据参数信息age的一个获取
    $res = information::Wzh_Find($age);
     return $res?
         json_success("操作成功",$res,200):
         json_fail("操作失败",null,100);


    }
}
