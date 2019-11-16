@extends('layouts.hadmin')

@section("title")
    素材展示
@endsection

@section('content')
    <h3><b>素材管理-素材展示</b></h3>
    <table class="table table-hover table table-bordered">
        <tr>
            <td>素材ID</td>
            <td>素材名称</td>
            <td>素材格式</td>
            <td>素材类型</td>
            <td>素材展示</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
        <tr>
            <td>{{$v->media_id}}</td>
            <td>{{$v->media_name}}</td>
            <td>{{$v->media_format}}</td>
            <td>
               @if($v->media_type==1)
                   临时素材
                @else
                永久素材
                   @endif
            </td>
            <td>
                @if($v->media_format=='image')
                    <img src="\{{$v->media_url}}" alt="" width="80px">
                 @elseif($v->media_format=='voice')
                    <audio src="\{{$v->media_url}}" controls="controls">12</audio>
                @elseif($v->media_format=='video')
                    <video src="\{{$v->media_url}}" controls="controls" width="200px"></video>
                @endif
            </td>
            <td>
                <a href="">编辑</a>
                <a href="">删除</a>
            </td>
        </tr>
            @endforeach
    </table>
@endsection