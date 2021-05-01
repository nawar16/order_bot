<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class OperationCommand extends Command
{

    protected $name = "operation";

    protected $description = "Available operation";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => trans('telegram.operation')]);
        $keyboard = [
            ['/one', '/two', '/three', '/example']
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
    }
}