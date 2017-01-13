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
     * @var CommandBus Parent commandbus.
     */
    protected $commamd_bus;

    /**
     * Constructor
     * @param CommandBus
     */
    public function __construct(CommandBus $command_bus)
    {
        $this->command_bus = $command_bus;
    }

    /**
     * Get Command Name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Command Name.
     * @param $name
     * @return Command
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Command Description.
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     * @param $description
     * @return Command
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get Command Bus.
     * @return CommandBus
     */
    public function getCommandBus()
    {
        return $this->command_bus;
    }

    /**
     * Get messenger Api instance
     * @return MBoretto\MessengerBot\Api;
     */
    public function getMessenger()
    {
        return $this->command_bus->getApi();
    }

    /**
     * Here's is implemented the logic of the command
     * All command need to return the messaggin entities
     * @param Messaging $messaging
     * @return Messaging $messaging
     */
    abstract public function handle(Messaging $messaging = null);
}
