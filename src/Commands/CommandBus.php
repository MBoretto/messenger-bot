<?php

namespace MBoretto\MessengerBot\Commands;

use MBoretto\MessengerBot\Api;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\Exception\MessengerException;
use \Closure;

/**
 * Class CommandBus.
 */
class CommandBus
{
   /**
     * @var Api
     */
    protected $api;

    /**
     * @var init_command[] Holds all init commands.
     */
    protected $init_commands = [];

    /**
     * @var webhook_command[] Holds all webhook commands.
     */
    protected $webhook_commands = [];

    /**
     * @var postback_command[] Holds all postback commands.
     */
    protected $postback_commands = [];

    /**
     * @var middleware[] Contain the middlewawre that haveto executed before and after each messaging
     */
    protected $middleware = [];

    /**
     * Instantiate Command Bus.
     *
     * @param MessengerBot $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

   /**
     * Add a list of commands that  will be executed when the webhook will be setted.
     * @param array $commands
     * @return CommandBus
     */
    public function addInitCommands(array $commands)
    {
        $this->init_commands = $commands;
        return $this;
    }

   /**
     * Add a list of commands.
     * @param array $commands
     * @return CommandBus
     */
    public function addWebhookCommands(array $commands)
    {
        foreach ($commands as &$command) {
            $this->addWebhookCommand($command);
        }
        return $this;
    }

   /**
     * Add a list of commands.
     * @param array $commands
     * @return CommandBus
     */
    public function addPostbackCommands(array $commands)
    {
        foreach ($commands as &$command) {
            $this->addPostbackCommand($command);
        }
        return $this;
    }

    /**
     * Add a command to the commands list.
     * @param CommandInterface|string $command Either an object or full path to the command class.
     * @return CommandBus
     */
    public function addWebhookCommand($command)
    {
        $this->addCommand($command, $this->webhook_commands);
    }

    /**
     * Add a command to the commands list.
     * @param CommandInterface|string $command Either an object or full path to the command class.
     * @return CommandBus
     */
    public function addPostbackCommand($command)
    {
        $this->addCommand($command, $this->postback_commands);
    }

    /**
     * Add a command to the commands list.
     * @todo
     * @param CommandInterface|string $command Either an object or full path to the command class.
     * @return CommandBus
     */
    protected function addCommand($command, &$command_level)
    {
        $command = $this->createObject($command);
        $command_level[$command->getName()] = $command;
        return $this;
    }

    /**
     * Create the object Command
     * @param CommandInterface|string $command Either an object or full path to the command class.
     * @throws MessengerException;
     * @return ObjectCommand
     */
    protected function createObject($command)
    {
        if (!is_object($command)) {
            if (!class_exists($command)) {
                throw new MessengerException(
                    sprintf(
                        'Command class "%s" not found! Please make sure the class exists.',
                        $command
                    )
                );
            }
            $command = new $command($this);
            if ($command instanceof Command) {
                return $command;
            }
            throw new MessengerException(
                sprintf(
                    'Command class "%s" should be an instance of "MBoretto\MessengerBot\Commands\Command"',
                    get_class($command)
                )
            );
        }
        throw new MessengerException(
            sprintf(
                'Command class "%s" is not an object! Please make sure the class exists.',
                $command
            )
        );
    }

    /**
     * Add the middleware thath need to be executed before and after each messaging
     * @param array $middleware
     * @return CommandBus
     */
    public function addMiddlewares(array $middlewares)
    {
        foreach ($middlewares as &$middleware) {
            $this->middleware[] = new $middleware($this->api);
        }
        return $this;
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     * @param Messaging $update
     * @todo
     * @return Update
     */
    public function handler(Messaging $messaging)
    {
        $callback = array_reduce($this->middleware, function ($next_layer, $layer) {
                return $this->createLayer($next_layer, $layer);
        }, $this->core());
        return $callback($messaging);
    }

    public function createLayer(Closure $next_layer, $layer)
    {
        return function (Messaging $messaging) use ($next_layer, $layer) {
            return $layer->handle($messaging, $next_layer);
        };
    }

   /**
     * Redirect the message to the corrext commands
     * If is a postback first it try to march the command name with the postback one
     * If no match is found the generic postback command is executed
     * If is a plain message the generic message commnas is executed
     * @return Closure
     * @TODO
     */
    public function core()
    {
        return function (Messaging $messaging) {
            if ($messaging->detectType() == 'postback') {
                $name = $messaging->getPostback()->getPayload();
                if (array_key_exists($name, $this->postback_commands)) {
                    return $this->postback_commands[$name]->handle($messaging);
                }
            }
            //   Kind of messages
            // Each field maps to a callback.
            //message
            //postback
            //optin
            //account_linking
            //delivery
            //read
            //checkout_update
            //payment

            //webhook updates
            //message Subscribes to Message Received Callback
            //messaging_postbacks Subscribes to Postback Received Callback
            //messaging_optins Subscribes to Authentication Callback via the Send-to-Messenger Plugin
            //message_deliveries Subscribes to Message Delivered Callback
            //message_reads Subscribes to Message Read Callback
            //message_echoes Subscribes to Message Echo Callback
            //messaging_checkout_updates (BETA) Subscribes to Checkout Update Callback
            //messaging_payments (BETA) Subscribes to Payment Callback
            //echo 'Executing: ' . ucfirst(camel_case($messaging->detectType()));
            $name = $messaging->detectType();
            if (array_key_exists($name, $this->webhook_commands)) {
                return $this->webhook_commands[$name]->handle($messaging);
            }
            throw new MessengerException(
                sprintf(
                    'Update not handled type: "%s" raw json: "%s"',
                    $name,
                    $messaging->toJson()
                )
            );
            return $messaging;
        };
    }

   /**
     * List of commands that  will be executed when the webhook will be setted.
     * @param array $commands
     * @return CommandBus
     */
    public function handleAllInitCommands()
    {
        foreach ($this->init_commands as &$command) {
            $this->createObject($command)->handle();
        }
        return $this;
    }

   /**
     * @retunr Api
     */
    public function getApi()
    {
        return $this->api;
    }
}
