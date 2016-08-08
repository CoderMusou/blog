<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $navs = Navs::all();
        $date = date('Y-m-d');
        $content=file_get_contents('http://open.iciba.com/dsapi/?date='.$date);
        $say=json_decode($content,true);
        View::share(['navs'=>$navs,'say'=>$say]);
    }

    public function Get_real_ip()
    {

        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return $ip ? $ip : $_SERVER['REMOTE_ADDR'];
    }
}
