@extends('layouts.hadmin')

@section("title")
    素材添加
@endsection

@section('content')
<div style="padding-left: 50px;padding-top: 50px">
    <form action="{{url('wechat/add_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        <h3><b>素材管理-素材上传</b></h3>
        <div class="form-group">
            <label for="exampleInputEmail1">素材名称</label>
            <input type="text" class="form-control" name="media_name" placeholder="素材名称">
        </div>

        <div class="form-group">
            <label for="exampleInputFile">素材文件</label>
            <input type="file" name="file" id="exampleInputFile">
        </div>

        <div class="form-group">
            <label for="disabledSelect">素菜类型</label>
            <select id="disabledSelect" class="form-control" name="media_type">
                <option value="1">临时素材</option>
                <option value="2">永久素材</option>
            </select>
        </div>


        <div class="form-group">
            <label for="disabledSelect">素菜格式</label>
            <select id="disabledSelect" class="form-control" name="media_format">
                <option value="image">图片</option>
                <option value="voice">音频</option>
                <option value="video">视频</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">上传</button>
    </form>
</div>
@endsection
