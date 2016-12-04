<?php

namespace Examples\Commands\Init;

use MBoretto\MessengerBot\Commands\Command;
use MBoretto\MessengerBot\Api;
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
    public function handle(Api $messenger, Messaging $messaging = null)
    {
        //set Persistent Menu
        $buttons = [];
        $buttons[] = new PostbackButton(['title' => 'show', 'payload' => 'custom_payload']);
        $data = new PersistentMenu();
        $data->setCallToActions($buttons);
        $messenger->sendThreadSetting($data->toJson());
    }
}
