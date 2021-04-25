<?php

namespace App\Http\Controllers;
require_once("../vendor/autoload.php");


use Illuminate\Http\Request;
use Telegram\Bot\Api as Api;
use \Telegram as Telegram;
use Carbon\Carbon;
use Exception;

class TelegramController1 extends Controller
{
    protected $telegram;

    protected $chat_id;
    public function __construct(){
        //Telegram::setTimeout(3000);
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
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
        $url = 'https://cryptoeco.herokuapp.com/'.env('TELEGRAM_BOT_TOKEN').'/webhook';
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
            //find all of the available commands
            case '/menu':
                $this->showMenu();
                break;
            case '/one':
                $this->showMenu();
                break;
            case '/two':
                $this->showMenu();
                break;
            case '/three':
                $this->showMenu();
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
        $message .= '/menu' . chr(10);
        $message .= '/one' . chr(10);
        $message .= '/two' . chr(10);
        $message .= '/three' . chr(10);
 
        //$content = array('chat_id' => $chat_id, 'text' => 'Hello');
        $this->sendMessage($message);
    }

 
    //////////////////////////Handling Input////////////////////////// 
    public function one()
    {
        $message = "You enter one";
        //saving a record to the databse
        Telegram::create([
            'username' => $this->username,
            'command' => __FUNCTION__//saving command, to tracking what method to do when we have multiple input handling
        ]);
 
        $this->sendMessage($message);
    }
    public function two()
    {
        $message = "You enter two";
        Telegram::create([
            'username' => $this->username,
            'command' => __FUNCTION__
        ]);
 
        $this->sendMessage($message);
    }
    public function three()
    {
        $message = "You enter three";
        Telegram::create([
            'username' => $this->username,
            'command' => __FUNCTION__
        ]);
 
        $this->sendMessage($message);
    }
    ////////////////////////////////////////////////////
 
    protected function sendMessage($message, $parse_html = false)
    {
        $data = [
            'chat_id' => $this->chat_id,
            'text' => $message,
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
}
    
