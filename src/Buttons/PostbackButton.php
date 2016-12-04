<?php

namespace MBoretto\MessengerBot\Buttons;

/**
 * Class PostbackButton.
 *
 * @todo
 * @method string      getId()        Sender user ID
 */
class PostbackButton extends BaseButton
{
    /**
     * {@inheritdoc}
     */
    public function setType()
    {
        $this->items['type'] = 'postback';
        return $this;
    }
}
