@extends('layouts.hadmin')

@section("title")
    渠道添加
@endsection

@section('content')
    <div style="padding-left: 50px;padding-top: 50px">
        <form action="{{url('wechat/channel_do')}}" method="post">
            @csrf
            <h3><b>渠道管理-渠道添加</b></h3>
            <div class="form-group">
                <label for="exampleInputEmail1">渠道名称</label>
                <input type="text" class="form-control" name="channel_name" placeholder="渠道名称">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">渠道标识</label>
                <input type="text" class="form-control" name="channel_status" placeholder="渠道标识">
            </div>

            <button type="submit" class="btn btn-primary">上传</button>
        </form>
    </div>
@endsection