<?php

namespace Examples\Commands\Init;

use MBoretto\MessengerBot\Commands\Command;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\ThreadSettings\GetStarted;

class SetGetStartedCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "setgetstartedbutton";

    /**
     * @var string Command Description
     */
    protected $description = "set get started button";

    /**
     * @inheritdoc
     */
    public function handle(Messaging $messaging = null)
    {
        //set GetStarted button
        $data = new GetStarted();
        $data->setCallToActions([['payload' => 'start']]);
        $this->getMessenger()->sendThreadSetting($data->toJson());
    }
}
