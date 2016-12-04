<?php

namespace MBoretto\MessengerBot\ThreadSettings;

/**
 * Class Greeting.
 *
 * @todo
 * @method string      getId()        Sender user ID
 */
class Greeting extends BaseThreadSetting
{
    /**
     * {@inheritdoc}
     */
    protected function setType()
    {
        $this->items['setting_type'] = 'greeting';
        return $this;
    }

    /**
     * @todo
     */
    public function setText($text)
    {
        $this->items['greeting']['text'] = $text;
        return $this;
    }
}
