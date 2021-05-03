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
    protected $username;
    public function __construct(){
        Telegram::setTimeout(20*3000);
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
        $updates = $this->telegram->getWebhookUpdates();
        //inline mode deal with callback
        if($updates->isType('callback_query')) {
            $query = $updates->getCallbackQuery();
            $data  = $query->getData();
            $chid = $request['callback_query']['message']['chat']['id'];

            $keyboard = Keyboard::make()
            ->inline()
            ->row(
                Keyboard::inlineButton(['text' => 'One ', 'callback_data' => '/One']),
                Keyboard::inlineButton(['text' => 'Two', 'callback_data' => '/Two'])
            );
            $this->telegram->sendMessage([
                'chat_id' => $chid,
                'text' => 'Here is the callback: ' . $data,
                'reply_markup' => $keyboard
            ]);
            return 'Ok';
        }

        $this->chat_id = $request['message']['chat']['id'];
        $this->username = $request['message']['from']['username'];
        $this->text = $request['message']['text'];
 
        $lang = Setting::where('chat_id', $this->chat_id)->first();
        if(!is_null($lang))
        {
            \App::setLocale($lang->locale);
            \Session::put('lang', $lang->locale);
        }


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
                case '/Arabic':
                    $this->arabic();
                    break;
                case '/English':
                    $this->english();
                    break;
                case '/One':
                    $this->one();
                    break;
                case '/Two':
                    $this->two();
                    break;
                case '/Three':
                    $this->three();
                    break;
                case '/Dep1':
                    $this->dep1();
                    break;
                case '/Dep2':
                    $this->dep2();
                    break;
                case '/Dep3':
                    $this->dep3();
                    break;
                case '/inline':
                    $this->inline();
                    break;
                case '/order':
                    $this->order();
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
            ['/Arabic', '/English']
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
        //$update = Telegram::commandsHandler(true);
        //return $this->telegram->triggerCommand('start', $update);
    }
    public function operation()
    {
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('operation', $update);
    }
    public function departments()
    {
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('departments', $update);
    }
    public function inline()
    {
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('one', $update);
    }

    public function one()
    {
        $message = trans('telegram.you_enter_one');
        $this->sendMessage($message);
        //$update = Telegram::commandsHandler(true);
        //return $this->telegram->triggerCommand('example', $update);
    }
    public function two()
    {
        $message = trans('telegram.you_enter_two');
        $this->sendMessage($message);
    }
    public function three()
    {
        $message = trans('telegram.you_enter_three');
        $this->sendMessage($message);
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
        $update = Telegram::commandsHandler(true);
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
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('departments', $update);
    }
    public function dep1()
    {
        $message = trans('telegram.you_choose_dep1');
        $this->sendMessage($message);
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('operation', $update);
    }
    public function dep2()
    {
        $message = trans('telegram.you_choose_dep2');
        $this->sendMessage($message);
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('operation', $update);
    }
    public function dep3()
    {
        $message = trans('telegram.you_choose_dep3');
        $this->sendMessage($message);
        $update = Telegram::commandsHandler(true);
        return $this->telegram->triggerCommand('operation', $update);
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
    ////////////////////////////////////////////////////////////////////////
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
    protected function sendMessageForVendor($message, $parse_html = false)
    {
        $data = [
            'chat_id' => "860132140",
            'text' => $message,
            'reply_markup' => $this->reply_markup
        ];
 
        if ($parse_html) $data['parse_mode'] = 'HTML';
 
        $this->telegram->sendMessage($data);
    }
    public function order()
    {
        $message = "client ".$this->username." ask for order";
        $this->sendMessageForVendor($message);
    }
}
    
