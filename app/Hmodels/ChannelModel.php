<?php

namespace App\Hmodels;

use Illuminate\Database\Eloquent\Model;

class ChannelModel extends Model
{
    //指定表名  因laravel框架默认表名比模型名多一 个s
    protected $table="channel";
    //指定主键id
    protected $primaryKey="channel_id";
    public $timestamps=false;
    protected $quarded=[];
}
