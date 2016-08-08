<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => ['web'],'namespace' => 'Home'], function () {

    Route::get('404', function () {
        return view('errors.404');
    });

    Route::any('/', 'IndexController@index');
    Route::any('links', 'IndexController@links');
    Route::any('about', 'IndexController@about');
    Route::any('search','IndexController@search');
    Route::any('cate/{cate_id?}', 'IndexController@cate')->where(['cate_id' => '[0-9]+']);
    Route::any('art/{art_id?}', 'IndexController@article')->where(['art_id' => '[0-9]+']);
    Route::post('art/zan/{art_id?}','IndexController@zambia')->where(['art_id' => '[0-9]+']);

});

Route::group(['middleware' => ['web'],'prefix' => 'admin','namespace' => 'Admin'], function () {

    Route::any('login', 'LoginController@login');
    Route::get('code', 'LoginController@code');
    Route::get('quit', 'LoginController@quit');

});

Route::group(['middleware' => ['web','admin.login'],'prefix' => 'admin','namespace' => 'Admin'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeorder', 'CategoryController@changeOrder');
    Route::resource('category', 'CategoryController');

    Route::post('article/changetop', 'ArticleController@changeTop');
    Route::resource('article', 'ArticleController');

    Route::post('links/changeorder', 'LinksController@changeOrder');
    Route::resource('links', 'LinksController');

    Route::post('navs/changeorder', 'NavsController@changeOrder');
    Route::post('navs/changeorder', 'NavsController@changeOrder');
    Route::resource('navs', 'NavsController');

    Route::get('config/putfile', 'ConfigController@putFile');
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    Route::resource('config', 'ConfigController');

    Route::any('upload', 'CommonController@upload');

});

