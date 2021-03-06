<?php

namespace Examples\Commands;

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
    public function handle(Messaging $messaging = null)
    {
        $sender_id = $messaging->getSender()->getId();
        $message = $messaging->getMessage();
        $text = $message->getText();

        //Plain message
        $messaging = new Messaging();
        $messaging->setRecipient(new Recipient(['id' => $sender_id]));
        $messaging->setMessage(new Message(['text' => 'Handling a generic postback command!']));
        $this->getMessenger()->sendMessage($messaging);
        return $messaging;
    }
}
