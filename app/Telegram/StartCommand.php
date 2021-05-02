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
    public function handle()
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
        $this->replyWithMessage([
            'text' => 'Hello! Welcome to our bot, chose your language : ',
            'reply_markup' => $reply_markup
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////
        $updates = $this->telegram->getWebhookUpdates();
        $chat_id = $updates["message"]["chat"]["id"];
        $text = $updates['message']['text'];
        switch ($text) {
            case '/English':
                $this->english();
                break;
            case '/Arabic':
                $this->arabic();
                break;   
            default:
                $this->english();
        }

        //$this->triggerCommand('operation');
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