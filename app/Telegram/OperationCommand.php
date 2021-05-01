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
       // $this->replyWithMessage(['text' => trans('telegram.operation')]);
        $update = $this->telegram->getWebhookUpdate();
        $keyboard = Keyboard::make()
        ->inline()
        ->row(
            Keyboard::inlineButton(['text' => 'One', 'callback_data' => '/One']),
            Keyboard::inlineButton(['text' => 'Two', 'callback_data' => '/Two']),
            Keyboard::inlineButton(['text' => 'Three', 'callback_data' => '/Three'])
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

            $chat_id = $update["message"]["chat"]["id"];

            $response = $this->replyWithMessage([
                'chat_id' => $chat_id,
                'text' => trans('telegram.operation'),
                'reply_markup' => $keyboard
            ]);
        }
        //$this->triggerCommand('operation');
    }
}