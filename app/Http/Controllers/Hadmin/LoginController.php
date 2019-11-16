<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hmodels\HloginModel;

class LoginController extends Controller
{
    public function login(){
        return view('hadmin.login');
    }
    public function loginDo(Request $request){
        if($request->isMethod('POST')) {
            $obj = new HloginModel();
            $where = [
                ["username", "=", $request->username],
                ["pwd", "=", md5($request->pwd)]
            ];
            $arr = $obj->where($where)->first();
            if ($arr) {
                $info = ["username" => $arr->username, "pwd" => $arr->id];
                session(['user' => $info]);
                session()->save();
                return redirect('hadmin/index');
            } else {
                echo "账号或密码错误";exit;
            }
        }

    }
}
