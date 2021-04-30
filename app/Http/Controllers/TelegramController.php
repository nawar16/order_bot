<?php

namespace App\Http\Controllers;
require_once("../vendor/autoload.php");


use Illuminate\Http\Request;
use Telegram\Bot\Api as Api;
use \Telegram as Telegram;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use Carbon\Carbon;
use Exception;

class TelegramController extends Controller
{
    protected $telegram;

    protected $reply_markup;
    protected $chat_id;
    public function __construct(){
        Telegram::setTimeout(3000);
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $keyboard = [
            ['/one', '/two', '/three', '/example']
        ];
        $this->reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);
        
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
            case '/one':
                $this->one();
                break;
            case '/two':
                $this->two();
                break;
            case '/three':
                $this->three();
                break;
            case '/example':
                $this->example_command();
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
        $message .= '/one' . chr(10);
        $message .= '/two' . chr(10);
        $message .= '/three' . chr(10);
        $message .= '/example' . chr(10);
 
        $this->sendMessage($message);
    }

 
    //////////////////////////Handling Input////////////////////////// 
    public function example_command()
    {
        $update = Telegram::commandsHandler(true); 
        return $this->telegram->triggerCommand('example', $update);
    }
    public function one()
    {
        $message = "You enter one";
        $this->sendMessage($message);
    }
    public function two()
    {
        $message = "You enter two";
        $this->sendMessage($message);
    }
    public function three()
    {
        $message = "You enter three";
        $this->sendMessage($message);
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
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }
    public function getUpdates(){
        $content = ['chat_id' => $this->chat_id, 'text' => 'HI'];
        $this->telegram->sendMessage($content);
    }

    public function test()
    {
        $updates = $this->telegram->getWebhookUpdates();
        dd($updates);
    }

}
    
