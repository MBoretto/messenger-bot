<?php

namespace MBoretto\MessengerBot\Middleware;

use \Closure;
use \MBoretto\MessengerBot\Objects\Messaging;

class AfterStoreMessaging extends Layer
{
    public function handle(Messaging $messaging, Closure $next)
    {
        $response = $next($messaging);
        //Do stuff
        echo 'Store request!!!';
        return $response;
    }
}
