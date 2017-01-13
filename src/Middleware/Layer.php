<?php

namespace MBoretto\MessengerBot\Middleware;

use \MBoretto\MessengerBot\Api;
use \MBoretto\MessengerBot\Objects\Messaging;
use \Closure;

abstract class Layer
{
    /**
     * @var Api can be shared across middleware
     */
    protected $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    abstract public function handle(Messaging $messaging, Closure $next);
}
