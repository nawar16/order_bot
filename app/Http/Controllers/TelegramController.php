<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api as Api;
use \Telegram as Telegram;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use Carbon\Carbon;
use Exception;
use App\Models\Setting;

class TelegramController extends Controller
{
    protected $telegram;

    protected $reply_markup;
    protected $chat_id;
    public function __construct(){
        //Telegram::setTimeout(3000);
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        \Session::put('lang', 'en');
        $this->middleware("Locale");
    }
    public function getMe(){
        $response = $this->telegram->getMe();
        return $response;
    }
    /**
     * creating a URL where Telegram will send a request once a new command is entered in our bot
     * https://api.telegram.org/bot.env('TELEGRAM_BOT_TOKEN')/getWebhookInfo
     */
    public function setWebHook(){
        $url = 'https://tele-bot-tests.herokuapp.com/api/'.env('TELEGRAM_BOT_TOKEN').'/webhook';
        $response = $this->telegram->setWebHook(['url' => $url]);
        return $response == true ?  redirect()->back() : dd($response);
    }
    /**
     * except from csrf verification
     * request sent by telegram webhook
     */
    public function handleRequest(Request $request){

        $this->chat_id = $request['message']['chat']['id'];
        $this->username = $request['message']['from']['username'];
        $this->text = $request['message']['text'];
 
        $updates = $this->telegram->getWebhookUpdates();
        //dd($updates);

        //calling the appropriate method based on the user command

        switch ($this->text) {
                case '/start':
                    $this->start();
                    break;
                case '/operation':
                    $this->operation();
                    break;
                case '/departments':
                    $this->departments();
                    break;
                case 'عربي':
                    $this->arabic();
                    break;
                case 'English':
                    $this->english();
                    break;
                case 'One':
                    $this->one();
                    break;
                case 'Two':
                    $this->two();
                    break;
                case 'Three':
                    $this->three();
                    break;
                case 'Dep1':
                    $this->dep1();
                    break;
                case 'Dep2':
                    $this->dep2();
                    break;
                case 'Dep3':
                    $this->dep3();
                    break;
                default:
                    $this->showMenu();
        }
    }
    public function showMenu($info = null)
    {
        $message = '';
        if ($info) {
            $message .= $info . chr(10);
        }
        $message .= '/start' . chr(10);
        $message .= '/departments' . chr(10);
        $message .= '/operation' . chr(10);
 
        $this->sendMessage($message);
    }

 
    //////////////////////////Handling Input////////////////////////// 
    public function start()
    {
        $keyboard = [
            ['عربي', 'English']
        ];
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);
        $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => 'Hello! Welcome to our bot, choose your language : ',
            'reply_markup' => $reply_markup
        ]);
        //$update = $this->telegram->getWebhookUpdates();
        //return $this->telegram->triggerCommand('start', $update);
    }
    public function operation()
    {
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('operation', $update);
    }
    public function departments()
    {
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('departments', $update);
    }

    public function one()
    {
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('example', $update);
    }
    public function two()
    {
        $message = trans('telegram.you_enter_two');
        $this->sendMessage($message);
    }
    public function three()
    {
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('example', $update);
    }
    public function english()
    {
        \App::setLocale('en');
        \Session::put('lang', 'en');
        $setting = Setting::where('chat_id', $this->chat_id)->first();
        if(!is_null($setting))
        {
            $setting->update([
                'locale' => 'en'
            ]);
        } else{
            Setting::create([
                'chat_id' => $this->chat_id,
                'locale' => 'en'
            ]);
        }
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('departments', $update);
    }
    public function arabic()
    {
        \App::setLocale('ar');
        \Session::put('lang', 'ar');
        $setting = Setting::where('chat_id', $this->chat_id)->first();
        if(!is_null($setting))
        {
            $setting->update([
                'locale' => 'ar'
            ]);
        } else{
            Setting::create([
                'chat_id' => $this->chat_id,
                'locale' => 'ar'
            ]);
        }
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('departments', $update);
    }
    public function dep1()
    {
        $message = trans('telegram.you_choose_dep1');
        $this->sendMessage($message);
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('operation', $update);
    }
    public function dep2()
    {
        $message = trans('telegram.you_choose_dep2');
        $this->sendMessage($message);
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('operation', $update);
    }
    public function dep3()
    {
        $message = trans('telegram.you_choose_dep3');
        $this->sendMessage($message);
        $update = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('operation', $update);
    }
    ////////////////////////////////////////////////////
 
    protected function sendMessage($message, $parse_html = false)
    {
        $data = [
            'chat_id' => $this->chat_id,
            'text' => $message,
            'reply_markup' => $this->reply_markup
        ];
 
        if ($parse_html) $data['parse_mode'] = 'HTML';
 
        $this->telegram->sendMessage($data);
    }
    ////////////////////////////////////////////////////
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }
    public function getUpdates(Request $request){
        $chat_id = $request['message']['chat']['id'];
        $content = ['chat_id' => $chat_id, 'text' => $request['message']['text']];
        $this->telegram->sendMessage($content);
    }

    public function test()
    {
        return $this->telegram->handle();
        //$updates = $this->telegram->getWebhookUpdates();
        //dd($updates);
    }
    public function check($chat_id)
    {
        $message = '/start';
        $parse_html = false;
        $data = [
            'chat_id' => $chat_id,
            'text' => $message,
            'reply_markup' => $this->reply_markup
        ];
 
        if ($parse_html) $data['parse_mode'] = 'HTML';
        $result = ($this->telegram)->sendMessage($data);
        return $result;
    }
}
    
