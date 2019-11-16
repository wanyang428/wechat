<?php

namespace App\Http\Controllers\wechat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Wechat;
use App\Models\SuggestModel;
use App\Hmodels\MediaModel;
use App\Hmodels\ChannelModel;
use App\Hmodels\WechatModel;

class WeekController extends Controller
{
    public function week_one(){
        //echo $_GET['echostr'];exit;
        $info=file_get_contents("php://input");

        file_put_contents("week.txt",$info);

        $arr_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        /** 关注回复 */
        if($arr_obj->MsgType=='event' && $arr_obj->Event=='subscribe'){
            //当用户关注后  如果是通过渠道关注  统计关注数量
            $channel_status=$arr_obj->EventKey;
            $openid=$arr_obj->FromUserName;
            dd($openid);
            $data=Wechat::get_wechat_user($openid);
            $nickname=$data['nickname'];

            if(!empty($channel_status)){
                $channel_status=ltrim($channel_status,'qrscene_');
                //关注人数字段递增
                $res = ChannelModel::where(['channel_status'=>$channel_status])->increment('num');
                $info=WechatModel::where("openid",$openid)->count();
                if ($info<1) {
                    $re = WechatModel::insert(['openid' => $openid, 'nickname' => $nickname, 'sex' => $data['sex'], 'channel_status' => $channel_status]);
                }
            }
            if($data['sex'] == 1){
                $sex="帅哥";
            }else{
                $sex="美女";
            }
            $msg="欢迎".$nickname.$sex."关注公众号";
            echo "<xml>
                  <ToUserName><![CDATA[".$arr_obj->FromUserName."]]></ToUserName>
                  <FromUserName><![CDATA[".$arr_obj->ToUserName."]]></FromUserName>
                  <CreateTime>".time()."</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[".$msg."]]></Content>
                </xml>";

        }
        /** 用户取关 */
        if($arr_obj->MsgType == 'event' && $arr_obj->Event == 'unsubscribe'){
            $channel_status=WechatModel::where('openid',$arr_obj->FromUserName)->value('channel_status');
//            $channel_status=$userInfo['channel_status'];
            $re= ChannelModel::where('channel_status',$channel_status)->decrement('num');
            dd($re);
        }
        /** 普通消息 */
        if($arr_obj->MsgType=='text'){
            if($arr_obj->Content==1){
                $msg='您好';
                echo Wechat::responseType($msg,$arr_obj);
            }else if(mb_strpos($arr_obj->Content,'建议+') !==false){
                $str=ltrim($arr_obj->Content,"建议+");
                //$res=\DB::table('suggest')->insert(['msg'=>$str]);
                $res=SuggestModel::insert(['msg'=>$str]);
                echo Wechat::responseType("已收到",$arr_obj);
            }
        }
        /** 斗图 */
        if($arr_obj->MsgType=='image'){

//               $access_token=Wechat::get_access_token();
//               $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
//               $img="/data/wwwroot/default/wechat/1565951548832700.jpg";
//               $data['media']=new \CURLFile($img);
//               $re=Wechat::curlpost($url,$data);
//               dd($re);
//               $msg="W8DE9_p9JGx52m6qynUJnGTFHyJe5Z4jY9tp6b9Qdy2Q5ZLk3M3bJS65O0Y7K6c5";
            $mediaData= MediaModel::where(['media_format'=>'image'])->inRandomOrder()->first();
            $media_id=$mediaData['wechat_media_id'];
            echo Wechat::responseImg($media_id,$arr_obj);
        }
        /** 语音 */
        if($arr_obj->MsgType=='voice'){
            $mediaData= MediaModel::where(['media_format'=>'voice'])->inRandomOrder()->first();
            $media_id=$mediaData['wechat_media_id'];
            echo Wechat::responseVoice($media_id,$arr_obj);
        }
        /** 视频 */
        if($arr_obj->MsgType=='video'){
            $mediaData= MediaModel::where(['media_format'=>'video'])->inRandomOrder()->first();
            $media_id=$mediaData['wechat_media_id'];
            echo Wechat::responseVideo($media_id,$arr_obj);
        }

    }
}
