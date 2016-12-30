<?php

namespace MBoretto\MessengerBot\ThreadSettings;

use Illuminate\Support\Collection;

/**
 * Class BaseButton.
 */
abstract class BaseThreadSetting extends Collection
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
     * Magic method to get/set properties dynamically.
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);

        if ($action === 'set') {
            $property = snake_case(substr($name, 3));
            $this->items[$property] = $arguments[0];
            return $this;
        }

        return false;
    }

    /**
     * Set button type.
     * @return array
     */
    abstract protected function setType();
}
