<?php
namespace App\Tools;

class Wechat
{
    /**
     * 回复文本消息
     * @param $msg
     * @param $arr_obj
     */
    const appId='wx11872538a7dc69ad';
    const appSecret ='652c55528c551a597b6d2d764b8df1c8';
    public static function responseType($msg, $arr_obj)
    {
        $Type = "<xml>
                  <ToUserName><![CDATA[" . $arr_obj->FromUserName . "]]></ToUserName>
                  <FromUserName><![CDATA[" . $arr_obj->ToUserName . "]]></FromUserName>
                  <CreateTime>" . time() . "</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[" . $msg . "]]></Content>
                </xml>";
        return $Type;
    }
    public static function responseImg($media_id,$arr_obj){
        $type= "<xml>
                      <ToUserName><![CDATA[".$arr_obj->FromUserName."]]></ToUserName>
                      <FromUserName><![CDATA[".$arr_obj->ToUserName."]]></FromUserName>
                      <CreateTime>".time()."</CreateTime>
                      <MsgType><![CDATA[image]]></MsgType>
                      <Image>
                        <MediaId><![CDATA[".$media_id."]]></MediaId>
                      </Image>
                    </xml>";
        return $type;
    }
    public static function get_access_token(){
        $access_token=\Cache::get('access_token');
        if(empty($access_token)){
            $url=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.Self::appId.'&secret='.Self::appSecret);
            $data=json_decode($url,1);
            $access_token=$data['access_token'];
            \Cache::put('access_token',$access_token,7200);
        }
        return $access_token;
    }
    /**
     * 获取用户基本信息
     */
    public static function get_wechat_user($openid){
        $data=self::get_access_token();
        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$data.'&openid='.$openid.'&lang=zh_CN';
        $re=file_get_contents($url);
        $result=json_decode($re,1);
        return $result;
    }
    //通过curl发送GET
    public static function curlget($url){
        //初始化： curl_init
        $curl = curl_init();
        //设置	curl_setopt
        curl_setopt($curl,CURLOPT_URL,$url);//请求地址
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//返回数据格式
        //访问https网站 关闭ssl验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        //执行  curl_exec
        $result=curl_exec($curl);
        //关闭（释放）  curl_close
        curl_close($curl);
        return $result;
    }
    //听过curl发送post
   public static function curlpost($url,$data)
    {
        //初始化： curl_init
        $ch = curl_init();
        //设置	curl_setopt
        curl_setopt($ch, CURLOPT_URL, $url);  //请求地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //返回数据格式
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //访问https网站 关闭ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        //执行  curl_exec
        $result = curl_exec($ch);
        //关闭（释放）  curl_close
        curl_close($ch);
        return $result;
    }

    /**
     * 临时素材文件上传
     * @param $path
     * @return mixed
     */
    public static function getMediaTmp($path,$format){
        $access_token = self::get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$format}";
        $data['media'] = new \CURLFile($path);
        $re = self::curlpost($url, $data);
        $re = json_decode($re, 1);
        $wechat_media_id = $re['media_id'];
        return $wechat_media_id;
    }

}