<?php

namespace Examples\Commands;

use MBoretto\MessengerBot\Objects\BaseObject;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Objects\Message;
use MBoretto\MessengerBot\Objects\Recipient;
use MBoretto\MessengerBot\Commands\Command;
use MBoretto\MessengerBot\Buttons\PostbackButton;
use MBoretto\MessengerBot\Buttons\ShareButton;
use MBoretto\MessengerBot\Templates\GenericTemplate;

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
    public function handle(Messaging $messaging = null)
    {
        $sender_id = $messaging->getSender()->getId();
        $message = $messaging->getMessage();
        $text = $message->getText();

        //Plain message
        $messaging = new Messaging();
        $messaging->setRecipient(new Recipient(['id' => $sender_id]));
        $messaging->setMessage(new Message(['text' => "Here's what I can do:"]));
        $this->getMessenger()->sendMessage($messaging);

        //carousel example
        $messaging = new Messaging();
        $messaging->setRecipient(new Recipient(['id' => $sender_id]));

        $element = new BaseObject;
        $element->setTitle('Carousel example');
        $element->setSubtitle('Carousel example');

        $buttons = [];
        $buttons[] = new PostbackButton(['title' => 'Button template', 'payload' => 'start']);
        $buttons[] = new ShareButton();

        $element->setButtons($buttons);
        //$element->setImageUrl("http://www.yourimage.png");

        $elements = [$element, $element];
        $generic_template = new GenericTemplate();
        $generic_template->setElements($elements);
        $message = new Message();
        $message->setAttachment($generic_template);

        $messaging->setMessage($message);
        $this->getMessenger()->sendMessage($messaging);
        return $messaging;
    }
}
