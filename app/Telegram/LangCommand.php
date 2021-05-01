<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;

class LangCommand extends Command
{

    protected $name = "lang";

    protected $description = "Change the language";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        //$this->replyWithMessage(['text' => 'Hello! Welcome to our bot, chose your language : ']);
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
        }
        //$this->triggerCommand('operation');
    }
}