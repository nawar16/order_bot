<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Telegram as Telegram;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/bot/getupdates', function() {
    $updates = Telegram::getUpdates();
    return (json_encode($updates));
});

Route::get('get-me','TelegramController@getMe');
Route::get('set-hook', 'TelegramController@setWebHook');

Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', 'TelegramController@handleRequest');

Route::get('/updated-activity', 'TelegramController@updatedActivity');
Route::post('/getUpdates', 'TelegramController@getUpdates');
Route::get('/test', 'TelegramController@test');
Route::post('/sendMessage', 'TelegramController@sendMessage1');
Route::get('/check/{chat_id}', 'TelegramController@check');