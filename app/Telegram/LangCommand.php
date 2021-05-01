<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class LangCommand extends Command
{

    protected $name = "lang";

    protected $description = "Change the language";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => 'Hello! Welcome to our bot, chose your language : ']);
        $keyboard = [
            ['/Arabic', '/English']
        ];
        
        $reply_markup = $this->getTelegram()->replyKeyboardMarkup([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);
        
        $response = $this->getTelegram()->sendMessage([
            'chat_id' => 'CHAT_ID', 
            'text' => 'Hello World', 
            'reply_markup' => $reply_markup
        ]);
        //$this->triggerCommand('operation');
    }
}