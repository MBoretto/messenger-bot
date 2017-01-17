<?php

namespace MBoretto\MessengerBot\QuickReply;

/**
 * Class LocationQuickReply.
 */
class LocationQuickReply extends BaseQuickReply
{
    /**
     * {@inheritdoc}
     */
    public function setContentType()
    {
        $this->items['content_type'] = 'location';
        return $this;
    }
}
