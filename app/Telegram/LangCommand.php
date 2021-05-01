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

        Log::info('handle');
        Log::info($update);

        if ($update->isType('callback_query')) {
            Log::info('...is callback');

        } else {

            Log::info('show keyboard...');

            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Arabic', 'callback_data' => '/Arabic']),
                    Keyboard::inlineButton(['text' => 'English', 'callback_data' => '/English'])
                );

            $this->replyWithMessage([
                'text'         => 'Hello! Welcome to our bot, chose your language : ',
                'reply_markup' => $keyboard
            ]);

            ////////////////////////////// handle inline button //////////////////////////////
            $update = $this->telegram->getWebhookUpdate();

            if ($update->isType('callback_query')) {
    
                $this->telegram->sendMessage([
                    'chat_id' => $update->callbackQuery->from->id,
                    'text' => $update->callbackQuery->data
                ]);
            } else {
                $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'Arabic', 'callback_data' => '/Arabic']),
                    Keyboard::inlineButton(['text' => 'English', 'callback_data' => '/English'])
                );
                $this->replyWithMessage([
                    'text'         => 'Hello! Welcome to our bot, chose your language : ',
                    'reply_markup' => $keyboard
                ]);
            }
        }
        //$this->triggerCommand('operation');
    }
}