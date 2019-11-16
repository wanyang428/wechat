@extends('layouts.hadmin')

@section("title")
    渠道展示
@endsection

@section('content')
    <h3 style="padding-top: 50px"><b>渠道管理-渠道展示</b></h3>

    <table class="table table-condensed">
        <tr class="success">
            <td>渠道id</td>
            <td>渠道名称</td>
            <td>渠道标识</td>
            <td>二维码</td>
            <td>推广数量</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
            <tr >
                <td>{{$v->channel_id}}</td>
                <td>{{$v->channel_name}}</td>
                <td>{{$v->channel_status}}</td>
                <td ><img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" class="click_img" alt="" width="80px"></td>
                <td>{{$v->num}}</td>
                <td>
                    <a href="" class="btn btn-success">编辑</a>
                    <a href="" class="btn btn-danger">删除</a>
                </td>
            </tr>
        @endforeach
    </table>
    <a href="/wechat/highcharts" class="btn btn-info">图表信息</a>
    <div class="bg_div" style="display: none;background: #ccc;width:100%;height:100%;position: absolute;top:0;left:0;opacity:0.8;text-align: center;padding-top: 10%">
        <div class="close_div" style="padding-left:20%">
            <b>关闭</b>
        </div>
        <img src="" style="width:300px">
    </div>
    <script>
        //选中谁操作谁
        $(".click_img").on('click',function(){
            //出现背景图
            $(".bg_div").show();
            //获取当前点击的img 标签路径
            var src=$(this).attr("src");
            $(".bg_div img").attr('src',src);
        })
        //点击关闭按钮隐藏
        $(".close_div").on('click',function(){
            //背景层隐藏
            $(".bg_div").hide();
        })
    </script>
@endsection