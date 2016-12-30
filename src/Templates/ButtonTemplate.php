<?php

namespace MBoretto\MessengerBot\Templates;

/**
 * Class ButtonTemplate.
 * @todo
 * @method string      getId()        Sender user ID
 */
class ButtonTemplate extends BaseTemplate
{
    /**
     * {@inheritdoc}
     */
    public function initPayload()
    {
        $this->items['payload']['template_type'] = 'button';
        return $this;
    }
}
