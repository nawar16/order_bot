<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;

class LangCommand extends Command
{

    protected $name = "lang";

    protected $description = "Change the language";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $update = $this->telegram->getWebhookUpdate();
        $keyboard = Keyboard::make()
        ->inline()
        ->row(
            Keyboard::inlineButton(['text' => 'Arabic', 'callback_data' => '/Arabic']),
            Keyboard::inlineButton(['text' => 'English', 'callback_data' => '/English'])
        );

        Log::info('handle');
        Log::info($update);

        if ($update->isType('callback_query')) {
            Log::info('...is callback');
            $query = $update->getCallbackQuery();
            $data  = $query->getData();
            $chid = $query->getFrom()->getId();
        
            $this->replyWithMessage([
                'chat_id' => $chid,
                'text' => 'Here is the callback: ' . $data,
                'reply_markup' => $keyboard
            ]);

        } else {

            Log::info('show keyboard...');

            $chat_id = $result["message"]["chat"]["id"];

            $response = $this->replyWithMessage([
                'chat_id' => $chat_id,
                'text' => 'Hello! Welcome to our bot, chose your language : ',
                'reply_markup' => $keyboard
            ]);
        }
        //$this->triggerCommand('operation');
    }
}