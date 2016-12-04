<?php

namespace Examples\Commands;

use MBoretto\MessengerBot\Api;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Objects\Message;
use MBoretto\MessengerBot\Objects\Recipient;
use MBoretto\MessengerBot\Commands\Command;

class GenericPostbackCommand extends Command
{
    /**
     * @var string Command Name must correspond to the wekhook update
     */
    protected $name = "postback";

    /**
     * @var string Command Description
     */
    protected $description = "Handle a generic postback update if it didn't match before the payload by a specific payload commands";

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
        $data->setMessage(new Message(['text' => 'Handling a generic postback command!']));
        $messenger->sendMessage($data->toJson());
    }
}
