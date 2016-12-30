<?php

namespace MBoretto\MessengerBot\Buttons;

/**
 * Class UrlButton.
 * @todo
 * @method string      getId()        Sender user ID
 */
class UrlButton extends BaseButton
{
    /**
     * {@inheritdoc}
     */
    public function setType()
    {
        $this->items['type'] = 'web_url';
        return $this;
    }
}
