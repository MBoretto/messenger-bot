<?php

namespace Examples\Commands\Postback;

use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Objects\Message;
use MBoretto\MessengerBot\Objects\Recipient;
use MBoretto\MessengerBot\Templates\ButtonTemplate;
use MBoretto\MessengerBot\Buttons\UrlButton;
use MBoretto\MessengerBot\Buttons\PostbackButton;
use MBoretto\MessengerBot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name must correspond to the postback payload
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command triggered by get started button";

    /**
     * @inheritdoc
     */
    public function handle(Messaging $messaging = null)
    {
        $sender_id = $messaging->getSender()->getId();
        //@todo get user information

        //Button Template example
        $messaging = new Messaging();
        $messaging->setRecipient(new Recipient(['id' => $sender_id]));
        $button_template = new ButtonTemplate();
        $button_template->setText('Hi! How can I help you?');
        $buttons = [];
        $buttons[] = new UrlButton(['url' => 'https://github.com/MBoretto/messenger-bot', 'title' => 'Github Project Link']);
        $buttons[] = new PostbackButton(['title' => 'Payload button', 'payload' => 'tell_me_more']);
        $button_template->setButtons($buttons);
        $message = new Message();
        $message->setAttachment($button_template);
        $messaging->setMessage($message);
        $this->getMessenger()->sendMessage($messaging);
        return $messaging;
    }
}
