<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;
use App\Models\Setting;

class DepartmentCommand extends Command
{

    protected $name = "departments";

    protected $description = "Available departments";

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
            ['/Dep1', '/Dep2' , '/Dep3']
        ];
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);


        $this->replyWithMessage([
            'text' => trans('telegram.departments'),
            'reply_markup' => $reply_markup
        ]);
    
        //$this->triggerCommand('operation', $updates);
    }
}