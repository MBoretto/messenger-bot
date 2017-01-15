<?php

namespace Examples\Commands\Init;

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
    public function handle(Messaging $messaging = null)
    {
        //set Greeting
        $data = new Greeting();
        $data->setText("Welcome there!");
        $this->getMessenger()->sendThreadSetting($data->toJson());
    }
}
