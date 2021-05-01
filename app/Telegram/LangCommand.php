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
        //$this->replyWithMessage(['text' => 'Hello! Welcome to our bot, chose your language : ']);
        $update = $this->telegram->getWebhookUpdate();

        Log::info('handle');
        Log::info($update);

        if ($update->isType('callback_query')) {
            Log::info('...is callback');

        } else {

            Log::info('show keyboard...');

            $options = [
                ['/Arabic', '/English']
            ];
            $keyboard = Keyboard::make([
                'keyboard' => $options, 
                'resize_keyboard' => true, 
                'one_time_keyboard' => true,
                'hide_keyboard'=> true
            ]);

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

            $cb = $this->telegram->getWebhookUpdate()->getCallbackQuery();
            $chatID = $cb->getId();
            $command = $cb->getData(); // here we receive 'callback_data' setted in created Menu
            switch ($command) {
                case '/English':
                    $this->english();
                    break;
                case '/Arabic':
                    $this->arabic();
                    break;    
                default:
                    $this->english();
            }
            $this->telegram->answerCallbackQuery([
                 'callback_query_id' => $chatID,
                 'text' => "CALLBACK RESPONSE",
                 'show_alert' => true // if you need modal window, not popup info
             ]);
        }
        //$this->triggerCommand('operation');
    }
    public function english()
    {
        \App::setLocale('en');
        $update = $this->telegram->commandsHandler(true); 
        return $this->replyWithMessage(['text' => 'you chose en']);
    }
    public function arabic()
    {
        \App::setLocale('ar');
        $update = $this->telegram->commandsHandler(true); 
        return $this->replyWithMessage(['text' => 'you chose ar']);
    }
}