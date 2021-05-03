<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard as Keyboard;
use \Telegram as Telegram;
use App\Models\Setting;

class PhoneNumberCommand extends Command
{

    protected $name = "phone";

    protected $description = "get phone number";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        
    }
}