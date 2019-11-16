<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Wechat;

class IndexController extends Controller
{
    public function index(){
        return view('hadmin.index');
    }
    //主页
    public function weather(){
        return view('hadmin.weather');
    }
    public function getWeather(Request $request){
        $city= $request->input('city');
        $weacherData=\Cache::get('weacherData_'.$city);
        if(empty($weacherData)){
            $url="http://api.k780.com/?app=weather.future&weaid=".$city."&ag=today,futureDay,lifeIndex,futureHour&appkey=46459&sign=862b1092b56602a448744f86e54e7c39&format=json";
            $weacherData=Wechat::curlget($url);
            $weacherData=json_decode($weacherData,1);
            \Cache::put('weacherData',$weacherData);
        }
        return $weacherData;


    }
}
