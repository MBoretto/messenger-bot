<?php

namespace MBoretto\MessengerBot\Templates;

/**
 * Class GenericTemplate.
 *
 * @todo
 * @method string      getId()        Sender user ID
 */
class GenericTemplate extends BaseTemplate
{
    /**
     * {@inheritdoc}
     */
    public function initPayload()
    {
        $this->items['payload']['template_type'] = 'generic';
        return $this;
    }
}
