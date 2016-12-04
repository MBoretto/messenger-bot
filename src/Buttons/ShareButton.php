<?php

namespace MBoretto\MessengerBot\Buttons;

/**
 * Class ShareButton.
 *
 * @todo
 * @method string      getId()        Sender user ID
 */
class ShareButton extends BaseButton
{
    /**
     * {@inheritdoc}
     */
    public function setType()
    {
        $this->items['type'] = 'element_share';
        return $this;
    }
}
