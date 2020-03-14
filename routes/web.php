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


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('sendmsg/mqtt/', 'MqttController@sendMsgViaMqtt')->name('sendmsg.mqtt');
    Route::post('subcribe/mqtt/', 'MqttController@subscribetoTopic')->name('subscribe.mqtt');

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('subscribe', 'HomeController@topicSubscribeView')->name('subscribe.view');
    Route::get('topics', 'HomeController@topicsView')->name('topics.view');

});