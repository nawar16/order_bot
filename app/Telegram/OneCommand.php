<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;

class OneCommand extends Command
{

    protected $name = "one";

    protected $description = "One Command to test";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        /*$telegram = $this->telegram;
        // First, we get the update.
        $result = $telegram->getWebhookUpdate();*/

        // No problems here...
        $keyboard = Keyboard::make()
        ->inline()
        ->row(
            Keyboard::inlineButton(['text' => 'One ', 'callback_data' => '/One']),
            Keyboard::inlineButton(['text' => 'Two', 'callback_data' => '/Two'])
        );


        $this->replyWithMessage([
            'text' => 'Test for inline keyboard',
            'reply_markup' => $keyboard
        ]);


        /*if ($result->isType('callback_query')) {
            $query = $result->getCallbackQuery();
            $data  = $query->getData();
            $chid = $query->getFrom()->getId();

        // again, you can't get the message object if the object is a callback_query.
        // in this case the $json variable would be undefined.
        // $json = json_decode($query->getMessage(), true);
        $telegram->sendMessage([
            'chat_id' => $chid,
            'text' => 'Here is the callback: ' . $data,
            'reply_markup' => $keyboard
        ]);

        // Just to make sure that there's a ['message']:
        } elseif(isset($result["message"])) {
            $chat_id = $result["message"]["chat"]["id"];

            $response = $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Hello',
                'reply_markup' => $keyboard
            ]);
        }*/
    }
}