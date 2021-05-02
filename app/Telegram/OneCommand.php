<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class OneCommand extends Command
{

    protected $name = "one";

    protected $description = "One Command to test";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $updates = $this->telegram->getWebhookUpdates();

        $chat_id = $updates['message']['chat']['id'];
        $username = $updates['message']['from']['username'];
        $text = $updates['message']['text'];

        
        $this->replyWithMessage(['text' => $text]);

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