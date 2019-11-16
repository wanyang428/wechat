<?php

namespace App\Hmodels;

use Illuminate\Database\Eloquent\Model;

class WechatModel extends Model
{
    //指定表名  因laravel框架默认表名比模型名多一个s
    protected $table="wechat_user";
    //指定主键id
    protected $primaryKey="wechat_user_id";
//    public $timestamps=false;
    protected $quarded=[];

    //模型默认的表主键为int类型,且自增 取消其属性
//    public $incrementing=false;
    //取消模型中自动添加的时间
    public $timestamps=false;
    //自定义时间字段
//    const CREATED_AT = "a_time";
//    const UPDATED_AT = "u_time";
    //将模型自动添加的时间改为int类型  默认字符串类型
//    protected $dateFormat="U";
}
