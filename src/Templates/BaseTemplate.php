<?php

namespace MBoretto\MessengerBot\Templates;

use Illuminate\Support\Collection;

/**
 * Class BaseTemplate.
 */
abstract class BaseTemplate extends Collection
{
    /**
     * Builds collection entity.
     * @param array|mixed $data
     */
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->items['type'] = 'template';
        $this->initPayload();
    }

    /**
     * Init template payload.
     * @return array
     */
    abstract protected function initPayload();

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
            $this->items['payload'][$property] = $arguments[0];
            return $this;
        }

        return false;
    }
}
