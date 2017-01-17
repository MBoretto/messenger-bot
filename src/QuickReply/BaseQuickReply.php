<?php

namespace MBoretto\MessengerBot\QuickReply;

use Illuminate\Support\Collection;

/**
 * Class QuickReply.
 */
abstract class BaseQuickReply extends Collection
{
    /**
     * Builds collection entity.
     * @param array|mixed $data
     */
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->setContentType();
    }

    /**
     * Set QuickReply content_type.
     * @return array
     */
    abstract protected function setContentType();
}
