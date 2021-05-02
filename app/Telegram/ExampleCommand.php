<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use \Telegram as Telegram;

class ExampleCommand extends Command
{

    protected $name = "example";

    protected $description = "Example Command to test";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $updates =  Telegram::getWebhookUpdates();
        

        $chat_id = $updates['message']['chat']['id'];
        $username = $updates['message']['from']['username'];
        $text = $updates['message']['text'];

        switch($text){
            case '/One':
                $this->replyWithMessage(['text' => trans('telegram.you_enter_one')]);
                break;
            case '/Two':
                $this->replyWithMessage(['text' => trans('telegram.you_enter_two')]);
                break;
            case '/Three':
                $this->replyWithMessage(['text' => trans('telegram.you_enter_three')]);
                break;
            default:
            $this->replyWithMessage(['text' => $text]);

        }

        //$this->replyWithMessage(['text' => 'Hello! Welcome to our bot, Here are our available commands:']);

        //$this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
        /*$commands = $this->getTelegram()->getCommands();

        // Build the list
        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        // Reply with the commands list
        $this->replyWithMessage(['text' => $response]);*/
    }
}