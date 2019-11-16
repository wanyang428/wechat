<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Hmodels\MediaModel;
use App\Tools\Wechat;

class MediaController extends Controller
{
    public function media(){
        return view('hadmin.media.media');
    }
    public function add_do(Request $request)
    {
        $data = $request->all();
        $file = $request->file('file');
        if (!$request->hasFile('file')) {
            echo "没有文件被上传";
            exit;
        }
        // $path=$request->file->store('aa');
        $ext = $file->getClientOriginalExtension();//后缀名
        $filename = md5(uniqid()) . "." . $ext;
        $path = $request->file->storeAs('imgs', $filename, 'local');
        $format=$data['media_format'];
       $wechat_media_id=Wechat::getMediaTmp($path,$format);
        $res = MediaModel::insert([
            'media_name' => $data['media_name'],
            'media_type' => $data['media_type'],
            'media_format' => $data['media_format'],
            'media_url' => $path,
            'wechat_media_id' => $wechat_media_id
        ]);
        if($res){
            session()->flash('media',"添加成功,素材id为");
            return redirect('/wechat/media_index');
        }

    }

    public function index(){
        $data=MediaModel::get();
        return view("hadmin.media.mediaIndex",['info'=>$data]);
    }

}
