<?php

namespace Examples\Commands;

use MBoretto\MessengerBot\Api;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Objects\Message;
use MBoretto\MessengerBot\Objects\Recipient;
use MBoretto\MessengerBot\Commands\Command;

class GenericMessageCommand extends Command
{
    /**
     * @var string Command Name must correspond to the wekhook update
     */
    protected $name = "message";

    /**
     * @var string Command Description
     */
    protected $description = "Handle a generic message update";

    /**
     * @inheritdoc
     */
    public function handle(Api $messenger, Messaging $messaging = null)
    {
        $sender_id = $messaging->getSender()->getId();
        $message = $messaging->getMessage();
        $text = $message->getText();

        //Plain message
        $data = new Messaging();
        $data->setRecipient(new Recipient(['id' => $sender_id]));
        $data->setMessage(new Message(['text' => "Sorry I can't understand.."]));
        $messenger->sendMessage($data->toJson());
    }
}
