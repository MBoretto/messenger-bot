# Messenger Bot
Php wrapper around the [Facebook Messenger Platform](https://developers.facebook.com/docs/messenger-platform).
Strongly inspired to [irazasyed/telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk) and 
[akalongman/php-telegram-bot](https://github.com/irazasyed/telegram-bot-sdk);

## Installation
1. [Set up the facebook page and application](https://developers.facebook.com/docs/messenger-platform/guides/setup)  

2. Library installation

    composer require mboretto/messenger-bot

3. Edit the [hook.php]((https://github.com/mbroretto/messenger-bot/examples/hook.example.php) file with your Facebook credential.

4. Point the webhook to your https domain.
## Features
- GenericTemplate, ButtonTemplate, ThreadSettings, Buttons, fetching user info and Commands...  
- Automatic message splitting if characters exceed the limit  
### Middleware
Sometimes you need to execute some routines for each incoming messaging object. 
In order to da this you can exploit the middleware layer. Middleware instances need to implement the _Middleware\Layer_ Class.
Middleware can be before the core function: 

```
<?php
namespace MBoretto\MessengerBot\Middleware;
use \Closure;
use \MBoretto\MessengerBot\Objects\Messaging;

class BeforeGetUser extends Layer
{
    public function handle(Messaging $messaging, Closure $next)
    {
        //My routine
        return $next($messaging);
    }
}
```

or after the core function:

```
<?php
namespace MBoretto\MessengerBot\Middleware;
use \Closure;
use \MBoretto\MessengerBot\Objects\Messaging;

class BeforeGetUser extends Layer
{
    public function handle(Messaging $messaging, Closure $next)
    {
        $messaging = $next($messaging);
        //My routine
        return $messaging;
    }
}
```

Middleware is inspired to Lumen/Laravel Pipeline.
## Commads
Commads needs to be registered in hook.php and must me istance of Commmand.php.
- When a Postback update is received, the CommandBus check if payload match the name of a postback command. If this occours the command is executed otherwise the GenericPostbackCommand.php will handle it.
- A simple text message is handled by GenericMessageCommand.php
- Init commands are executed everytime the webhook is setted

## Additional information
Any issues, feedback, suggestions or questions please use issue tracker [here](https://github.com/MBoretto/messenger-bot/issues).

