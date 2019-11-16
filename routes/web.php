<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>['CheckLogin']],function(){
    //商品
    Route::get('/','Admin\ShopController@index');
    Route::any('/shop/index','Admin\ShopController@index');
    Route::any('/shop/save','Admin\ShopController@save');
    Route::any('/shop/info','Admin\ShopController@info');
    //删除
    Route::any('/shop/delete/{id}','Admin\ShopController@delete');
    //修改
    Route::get('/shop/edit/{id}','Admin\ShopController@edit');
    Route::post('/shop/edit/{id}','Admin\ShopController@update');


    //管理
    Route::any('/admin/index','Admin\AdminController@index');
    Route::any('/admin/save','Admin\AdminController@save');
    //删除
    Route::any('/admin/delete/{id}','Admin\AdminController@delete');
    //修改
    Route::get('/admin/edit/{id}','Admin\AdminController@edit');
    Route::post('/admin/edit/{id}','Admin\AdminController@update');


    //分类
    Route::any('/sort/index','Admin\SortController@index');
    Route::any('/sort/save','Admin\SortController@save');
    Route::any('/sort/delete','Admin\SortController@delete');
    Route::any('/sort/update','Admin\SortController@update');
    //删除
    Route::any('/sort/delete/{id}','Admin\SortController@delete');
    //修改
    Route::get('/sort/edit/{id}','Admin\SortController@edit');
    Route::post('/sort/edit/{id}','Admin\SortController@update');

    //品牌
    Route::any('/brand/index','Admin\BrandController@index');
    Route::any('/brand/save','Admin\BrandController@save');
    //删除
    Route::any('/brand/delete/{id}','Admin\BrandController@delete');
    //修改
    Route::get('/brand/edit/{id}','Admin\BrandController@edit');
    Route::post('/brand/edit/{id}','Admin\BrandController@update');




    // Route::get('/logout', 'admin\UserController@index')->name('logout');
    // Route::get('/send', 'admin\UserController@send');


    //注册 登录
    Route::get('/logout', 'admin\UserController@logout')->name('logout');

    Route::get('/send', 'admin\UserController@send');

});

//测试公众号一
Route::any('/wechat/event', 'wechat\\WechatController@event');
//测试公众号二
Route::any('/wechat/week_one', 'wechat\\WeekController@week_one');

Route::any('/wechat/test', 'wechat\\WechatController@test');
//获取token
Route::any('/wechat/get_access_token', 'wechat\\WechatController@get_access_token');
//获取用户基本信息
Route::any('/wechat/get_wechat_user', 'wechat\\WechatController@get_wechat_user');
//素材管理
//Route::any('/wechat/media', 'wechat\\WechatController@media');
//添加素材
Route::any('/wechat/media', 'Hadmin\\MediaController@media');
Route::any('/wechat/add_do', 'Hadmin\\MediaController@add_do');
Route::any('/wechat/media_index', 'Hadmin\\MediaController@index');
//渠道管理
Route::any('/wechat/channel', 'Hadmin\\ChannelController@channel');
Route::any('/wechat/channel_do', 'Hadmin\\ChannelController@channel_do');
Route::any('/wechat/channel_index', 'Hadmin\\ChannelController@channel_index');
Route::any('/wechat/highcharts', 'Hadmin\\ChannelController@highcharts');

//主页
Route::any('/wechat/weather', 'Hadmin\\IndexController@weather');
Route::any('/wechat/getWeather', 'Hadmin\\IndexController@getWeather');

//后台登录
Route::any('/hadmin/login', 'Hadmin\\LoginController@login');
Route::any('/hadmin/loginDo', 'Hadmin\\LoginController@loginDo');
//后台首页
Route::any('/hadmin/index', 'Hadmin\\IndexController@index');

