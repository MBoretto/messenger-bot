<?php

namespace Examples\Commandsi\Init;

use MBoretto\MessengerBot\Api;
use MBoretto\MessengerBot\Commands\Command;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\ThreadSettings\Greeting;

class SetGreetingCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "setgreeting";

    /**
     * @var string Command Description
     */
    protected $description = "Set greeting message";

    /**
     * @inheritdoc
     */
    public function handle(Api $messenger, Messaging $messaging = null)
    {
        //set Greeting
        $data = new Greeting();
        $data->setText("Welcome there!");
        $messenger->sendThreadSetting($data->toJson());
    }
}
