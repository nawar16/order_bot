<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;

class StartCommand extends Command
{

    protected $name = "start";

    protected $description = "Choose the language";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $keyboard = [
            ['عربي', 'English']
        ];
        /*$inline_keyboard = [
            [
                [ "text" => "عربي", "callback_data" => "Arabic" ],
                [ "text" => "English", "callback_data" => "English" ],
            ]
        ];
        $keyboard = [
            array(
                array('text'=>'عربي','callback_data'=>'Arabic'),
                array('text'=>'English','callback_data'=>'English')
            )
        ];*/
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);
        $this->replyWithMessage([
            'text' => 'Hello! Welcome to our bot, choose your language : ',
            'reply_markup' => $reply_markup
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////
        //$this->triggerCommand('operation');
    }
}