<?php

namespace App\Messenger\Commands\Postback;

use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Objects\Message;
use MBoretto\MessengerBot\Objects\Recipient;
use MBoretto\MessengerBot\Objects\BaseObject;
use MBoretto\MessengerBot\Templates\GenericTemplate;
use MBoretto\MessengerBot\QuickReply\TextQuickReply;
use MBoretto\MessengerBot\QuickReply\LocationQuickReply;

class SettingsCommand extends Command
{
    /**
     * @var string Command Name must correspond to the postback payload
     */
    protected $name = "quickreply";

    /**
     * @var string Command Description
     */
    protected $description = "quick reply example";

    /**
     * @inheritdoc
     */
    public function handle(Messaging $messaging = null)
    {
        $sender_id = $messaging->getSender()->getId();

        //Plain message
        $messaging = new Messaging();
        $messaging->setRecipient(new Recipient(['id' => $sender_id]));
        $quick_replies = [];
        $quick_replies[] = new TextQuickReply(['title' => 'yes', 'payload' => 'yes']);
        $quick_replies[] = new TextQuickReply(['title' => 'no', 'payload' => 'no']);
        $quick_replies[] = new TextQuickReply(['title' => 'maybe', 'payload' => 'maybe']);
        $quick_replies[] = new LocationQuickReply();
        $message = new Message(['text' => "Quick reply example"]);
        $message->setQuickReplies($quick_replies);
        $messaging->setMessage($message);
        return $this->getMessenger()->sendMessage($messaging);
    }
}
