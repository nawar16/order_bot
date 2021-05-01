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

    protected $description = "Chose the language";

    /**
     * @inheritdoc
     */
    public function handle()
    {

        $keyboard = [
            ['/Arabic', '/English']
        ];
        $this->reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);

        $updates = $this->telegram->getWebhookUpdates();

        $chat_id = $updates["message"]["chat"]["id"];
        $this->text = $updates['message']['text'];

        $this->replyWithMessage([
            'chat_id' => $chat_id,
            'text' => 'Hello! Welcome to our bot, chose your language : ',
            'reply_markup' => $keyboard
        ]);

///////////////////////////////////////////////////////////////////////////////////////////
        $updates = $this->telegram->getWebhookUpdates();

        $chat_id = $updates["message"]["chat"]["id"];
        $this->text = $updates['message']['text'];

                
                switch ($this->text) {
                    case '/English':
                        $this->english();
                        break;
                    case '/Arabic':
                        $this->arabic();
                        break;   
                    default:
                        $this->english();
                }

        $this->triggerCommand('operation');
    }
    public function english()
    {
        \App::setLocale('en');
        $updates = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('operation', $updates);
    }
    public function arabic()
    {
        \App::setLocale('ar');
        $updates = $this->telegram->getWebhookUpdates();
        return $this->telegram->triggerCommand('operation', $updates);
    }
}