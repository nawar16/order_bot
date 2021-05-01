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
        $this->replyWithMessage(['text' => trans('telegram.operation')]);

        $this->triggerCommand('example');
    }
}