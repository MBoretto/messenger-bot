<?php

namespace Examples\Commands\Init;

use MBoretto\MessengerBot\Commands\Command;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Buttons\PostbackButton;
use MBoretto\MessengerBot\ThreadSettings\PersistentMenu;

class SetMenuCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "setmenu";

    /**
     * @var string Command Description
     */
    protected $description = "set the bot persistent menu";

    /**
     * @inheritdoc
     */
    public function handle(Messaging $messaging = null)
    {
        //set Persistent Menu
        $buttons = [];
        $buttons[] = new PostbackButton(['title' => 'Start', 'payload' => 'start']);
        //$buttons[] = new PostbackButton(['title' => 'Test', 'payload' => 'start']);
        $data = new PersistentMenu();
        $data->setCallToActions($buttons);
        $this->getMessenger()->sendThreadSetting($data->toJson());
    }
}
