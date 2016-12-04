<?php

namespace MBoretto\MessengerBot\ThreadSettings;

/**
 * Class GetStarted.
 *
 * @todo
 * @method string      getId()        Sender user ID
 */
class GetStarted extends BaseThreadSetting
{
    /**
     * {@inheritdoc}
     */
    protected function setType()
    {
        $this->items['setting_type'] = 'call_to_actions';
        $this->items['thread_state'] = 'new_thread';
        return $this;
    }
    
    /**
     * @todo
     */
    public function setText($text = null)
    {
        $this->items['greeting']['text'] = $text;
        return $this;
    }
}
