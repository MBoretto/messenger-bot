<?php

namespace MBoretto\MessengerBot\Commands;

use MBoretto\MessengerBot\Api;
use MBoretto\MessengerBot\Objects\Messaging;

abstract class Command
{
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name;

    /**
     * @var Command description.
     */
    protected $description;

    /**
     * Get Command Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Command Name.
     *
     * @param $name
     *
     * @return Command
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Command Description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     *
     * @param $description
     *
     * @return Command
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Here's is implemented the logic of the command
     *
     * @param Api $messenger
     * @param Messaging $update
     */
    abstract public function handle(Api $messenger, Messaging $messaging = null);
}
