<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;

class OperationCommand extends Command
{

    protected $name = "operation";

    protected $description = "Available operation";

    /**
     * @inheritdoc
     */
    public function handle()
    {
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


        $updates = $this->telegram->getWebhookUpdates();

        $chat_id = $updates['message']['chat']['id'];
        $username = $updates['message']['from']['username'];
        $text = $updates['message']['text'];
 
        //$this->triggerCommand('example', $updates);

    
    }
}