<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use \GuzzleHttp\Client;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('get-me','TelegramController@getMe');
Route::get('set-hook', 'TelegramController@setWebHook');

Route::post(env('TELEGRAM_BOT_TOKEN') . '/webhook', 'TelegramController@handleRequest');

Route::get('/updated-activity', 'TelegramController@updatedActivity');
Route::post('/getUpdates', 'TelegramController@getUpdates');