<?php

namespace MBoretto\MessengerBot\Buttons;

use Illuminate\Support\Collection;

/**
 * Class BaseButton.
 */
abstract class BaseButton extends Collection
{
    /**
     * Builds collection entity.
     * @param array|mixed $data
     */
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->setType();
    }

    /**
     * Set button type.
     * @return array
     */
    abstract protected function setType();
}
