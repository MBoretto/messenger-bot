<?php

namespace MBoretto\MessengerBot\Middleware;

use \Closure;
use \MBoretto\MessengerBot\Objects\Messaging;

class BeforeGetUser extends Layer
{
    public function handle(Messaging $messaging, Closure $next)
    {
        $sender_id = $messaging->getSender()->getId();
        try {
            $user_info = json_decode($this->api->getUser($sender_id), true);
        } catch (MBoretto\MessengerBot\Exception\MessengerResponseException $e) {
            return;
        }
        $messaging->setUserInfo($user_info);
        return $next($messaging);
    }
}
