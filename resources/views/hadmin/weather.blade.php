@extends('layouts.hadmin')

@section('title')
    搜索天气
@endsection

@section('content')
    <h3><b>一周气温展示</b></h3>
    城市：<input type="text" name="city">
    <input type="button" value="搜索" id="search">（城市名可以为拼音和汉子）

    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>

    <script>
        //已进入页面默认查询天气数据
        $.ajax({
            url:"{{url('wechat/getWeather')}}",//请求地址
            type:'GET',//请求方式
            data:{city: "北京"},//传输的数据
            dataType:"json",//返回的数据类型
            success:function(res){ //成功执行的方法
                //展示 图表天气数据
                showWeacher(res.result);
            }

        })

        $("#search").on('click',function(){
            var city=$('[name="city"]').val();
            if(city == ''){
                alert("请填写城市");
                return;
            }
            var reg=/^[a-zA-Z]+$|^[\u4e00-\u9fa5]+$/;
            var res=reg.test(city);
            if(!res){
                alert("城市名只能为拼音和汉字");return;
            }
            $.ajax({
                url:"{{url('wechat/getWeather')}}",//请求地址
                type:'GET',//请求方式
                data:{city:city},//传输的数据
                dataType:"json",//返回的数据类型
                success:function(res){ //成功执行的方法
                    //展示 图表天气数据
                    showWeacher(res.result);
                }

            })
        });

        function showWeacher(weacherData){
            //根据天气数据 展示一周天气
            var daysArr=[];

            var temperature=[];

            $.each(weacherData,function(k,v){
                daysArr.push(v['days']);
                temperature.push([parseInt(v['temp_low']),parseInt(v['temp_high'])]);
            })
            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'columnrange', // columnrange 依赖 highcharts-more.js
                    inverted: true
                },
                title: {
                    text: '一周温度变化范围'
                },
                subtitle: {
                    text: weacherData[0]['citynm']
                },
                xAxis: {
                    categories: daysArr
                },
                yAxis: {
                    title: {
                        text: '温度 ( °C )'
                    }
                },
                tooltip: {
                    valueSuffix: '°C'
                },
                plotOptions: {
                    columnrange: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return this.y + '°C';
                            }
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: '温度',
                    data: temperature
                }]
            });
        }

    </script>
@endsection