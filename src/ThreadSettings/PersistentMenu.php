<?php

namespace MBoretto\MessengerBot\ThreadSettings;

/**
 * Class PersistentMenu.
 *
 * @todo
 * @method string      getId()        Sender user ID
 */
class PersistentMenu extends BaseThreadSetting
{
    /**
     * {@inheritdoc}
     */
    protected function setType()
    {
        $this->items['setting_type'] = 'call_to_actions';
        $this->items['thread_state'] = 'existing_thread';
        return $this;
    }
    
    /**
     * @todo
     */
    public function setCallToActions(array $payloads)
    {
        $this->items['call_to_actions'] = $payloads;
        return $this;
    }
}
