<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Wechat;

class WechatController extends Controller
{
    public function event(){
        //接口配置
//        echo $_GET['echostr'];exit;
        //接受从微信服务器post过来的xml数据
        $info =file_get_contents("php://input");
//        file_put_contents("1.txt",$info);
        file_put_contents(storage_path('logs/wechat/'.date(  "Y-m-d").'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/'.date("Y-m-d").'.log'),"$info\n",FILE_APPEND);
        //处理xml数据 讲xml格式数据转换xml格式的对象
        $arr_obj=simplexml_load_string($info,"SimpleXMLElement",LIBXML_NOCDATA);
        /** @var  $fromusername
        $fromusername=$arr_obj->FromUserName;
        $tousername=$arr_obj->ToUserName;
        $time=time();
         */
        //判断是推送事件 不是消息
        if($arr_obj->MsgType == 'event' && $arr_obj->Event=='subscribe'){
            $openid=$arr_obj->FromUserName;
            $userInfo = Wechat::get_wechat_user($openid);
//            dd($userInfo);
            $nickname=$userInfo['nickname'];
            $content="欢迎".$nickname."关注我的公众号";
            echo "<xml>
                      <ToUserName><![CDATA[".$arr_obj->FromUserName."]]></ToUserName>
                      <FromUserName><![CDATA[".$arr_obj->ToUserName."]]></FromUserName>
                      <CreateTime>".time()."</CreateTime>
                      <MsgType><![CDATA[text]]></MsgType>
                      <Content><![CDATA[".$content."]]></Content>
                    </xml>";exit;
        }
        if($arr_obj->MsgType=='text'){
            if($arr_obj->Content==1){
                $msg="我喜欢你";
                echo Wechat::responseType($msg,$arr_obj);
            }else if(mb_strpos($arr_obj->Content,'天气') !== false){

                //得到城市名称
                $city=rtrim($arr_obj->Content,'天气');
                if(empty($city)){
                    $city="北京";
                }
                //调用接口
                $url="http://api.k780.com/?app=weather.future&weaid={$city}&ag=today,futureDay,lifeIndex,futureHour&appkey=46459&sign=862b1092b56602a448744f86e54e7c39&format=json";
                //请求方式
                $data=file_get_contents($url);
                $data=json_decode($data,1);
                //参数
                $msg="";
                foreach ($data['result'] as $key=>$val){
                    $msg .=$val['days']." ".$val['citynm']." ".$val['week']." ".$val['temperature']." ".$val['weather']." ".$val['wind']."\n";
                }
                echo Wechat::responseType($msg,$arr_obj);
            }
        }

    }

    /**
    public  function test(){
    //调用接口
    $url="http://api.k780.com/?app=weather.future&weaid=1&ag=today,futureDay,lifeIndex,futureHour&appkey=46459&sign=862b1092b56602a448744f86e54e7c39&format=json";
    //请求方式
    $data=file_get_contents($url);
    $data=json_decode($data,1);
    //参数
    $msg="";
    foreach ($data['result'] as $key=>$val){
    $msg .=$val['days']." ".$val['citynm']." ".$val['week']." ".$val['temperature']." ".$val['weather']." ".$val['wind']."\n";
    }

    //        $str="上海天气";
    //        if(mb_strpos($str,'天气') !== false){
    //            //得到城市名称
    //            $city=rtrim($str,'天气');
    //            if(empty($city)){
    //                $city="北京";
    //            }
    //            echo $city;exit;
    //        }else{
    //            echo 222;exit;
    //        }
    } */
    /**
     * 获取access_token
     * 如果token没有过期 直接返回token
     * file_exists() 检测文件或目录是否存在  filemtime() 获取文件的修改时间
     */
    //    public static function get_access_token(){
    //        if(file_exists("access_token.txt") && (time() - filemtime('access_token.txt')<7200) ){
    //            $access_token =file_get_contents("access_token.txt");
    //        }else{
    //            //如果token过期了 重新获取
    //            $url=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx11872538a7dc69ad&secret=652c55528c551a597b6d2d764b8df1c8');
    //            $data=json_decode($url,1);
    //            $access_token=$data['access_token'];
    //            //存储
    //            file_put_contents("access_token.txt",$access_token);
    //            return $access_token;
    //        }
    //        return $access_token;
    //    }
    /**
        const appId='wx11872538a7dc69ad';
        const appSecret ='652c55528c551a597b6d2d764b8df1c8';
        public static function get_access_token(){
            $access_token=\Cache::get('access_token');;
            if(empty($access_token)){
                $url=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.Self::appId.'&secret='.Self::appSecret);
                $data=json_decode($url,1);
                $access_token=$data['access_token'];
                \Cache::put('access_token',$access_token,7200);
            }
            return $access_token;
        }
     */
        /**
         * 获取用户基本信息
         */
        /**
        public static function get_wechat_user($openid){
            $data=self::get_access_token();
            $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$data.'&openid='.$openid.'&lang=zh_CN';
            $re=file_get_contents($url);
            dd($re);
        }
*/
//    public function media(){
//        $access_token=Wechat::get_access_token();
//        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
//        $img="D:/phpstudy_pro/WWW/1565951548832700.jpg";
//        $data['media']=new \CURLFile($img);
//        $re=Wechat::curlpost($url,$data);
//        dd($re);
//    }

}

