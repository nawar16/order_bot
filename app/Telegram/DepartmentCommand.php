<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;

class DepartmentCommand extends Command
{

    protected $name = "department";

    protected $description = "Available departments";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $keyboard = [
            ['/Dep1', '/Dep2' , '/Dep3']
        ];
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
            'hide_keyboard'=> true
        ]);


        $this->replyWithMessage([
            'text' => trans('telegram.departments'),
            'reply_markup' => $reply_markup
        ]);
    
        $this->triggerCommand('operation', $updates);
    }
}