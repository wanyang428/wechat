<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Wechat;
use App\Hmodels\ChannelModel;

class ChannelController extends Controller
{
    public function channel(){
        return view('hadmin.channel.channel');
    }
    public function channel_do(Request $request){
        $data=$request->all();
        $access_token=Wechat::get_access_token();
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
        $re="{\"expire_seconds\": 604800, \"action_name\": \"QR_SCENE\", \"action_info\": {\"scene\": {\"scene_id\": {$data['channel_status']}}}}";
        $curl=Wechat::curlpost($url,$re);
        $res=json_decode($curl,1);
        $ticket=$res['ticket'];
        $result = ChannelModel::insert([
            'channel_name'=>$data['channel_name'],
            'channel_status'=>$data['channel_status'],
            'ticket'=>$ticket,
            'num'=>0,
        ]);
        if($result){
            return redirect('wechat/channel_index');
        }


    }
    public function channel_index(){
        $info=ChannelModel::get();
        return view('hadmin.channel.channelIndex',['info'=>$info]);
    }
    public function highcharts(){
        $data=ChannelModel::get()->toArray();
        $nameStr="";
        $numStr="";
        foreach ($data as $key=>$val){
            $nameStr .= '"'.$val['channel_name'].'",';
            $numStr  .= $val['num'].',';
        }
        $nameStr=rtrim($nameStr,',');
        $numStr=rtrim($numStr,',');
        return view('hadmin.channel.highcharts',[
            'data'=>$data,
            'nameStr'=>$nameStr,
            'numStr'=>$numStr
        ]);
    }
}

