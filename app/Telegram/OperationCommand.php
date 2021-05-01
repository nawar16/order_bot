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

        $keyboard = [
            ['/one', '/two', '/three']
        ];
        $this->reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);
        //$this->triggerCommand('operation');
    }
}