<?php

namespace MBoretto\MessengerBot\QuickReply;

/**
 * Class TextQuickReply.
 */
class TextQuickReply extends BaseQuickReply
{
    /**
     * {@inheritdoc}
     */
    public function setContentType()
    {
        $this->items['content_type'] = 'text';
        return $this;
    }
}
