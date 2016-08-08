<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file -> isValid()){
            //检验一下上传的文件是否有效.
            $realPath = $file -> getRealPath();    //这个表示的是缓存在tmp文件夹下的文件的绝对路径，例如我的是: C:\wamp\tmp\php9372.tmp
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'\uploads',$newName);

            $filepath = 'uploads/'.$newName;

            return $filepath;
        }
    }
}
