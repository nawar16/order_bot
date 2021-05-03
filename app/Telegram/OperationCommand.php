<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;
use App\Models\Setting;

class OperationCommand extends Command
{

    protected $name = "operation";

    protected $description = "Available operations";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $chat_id = $this->chat->get('id');
        $lang = Setting::where('chat_id', $chat_id)->first();
        if(!is_null($lang))
        {
            \App::setLocale($lang->locale);
            \Session::put('lang', $lang->locale);
        }
        
        $keyboard = [
            ['/One', '/Two' , '/Three']
        ];
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);


        $this->replyWithMessage([
            'text' => trans('telegram.operation'),
            'reply_markup' => $reply_markup
        ]);


 
        //$this->triggerCommand('example', $updates);

    
    }
}