<?php

// Load composer
require __DIR__ . '/vendor/autoload.php';

// Add you bot's token and verify_token
$TOKEN = 'your_bot_token';
$VERIFY_TOKEN = 'your_bot_token';

use MBoretto\MessengerBot\Exception\MessengerException;
use Symfony\Component\HttpFoundation\Request;

try {
    // Create Telegram API object
    $messenger_bot = new MBoretto\MessengerBot\Api($TOKEN, $VERIFY_TOKEN);

    $messenger_bot->commandBus()->addInitCommands([
        Examples\Commands\Init\SetMenuCommand::class,
        Examples\Commands\Init\SetGreetingCommand::class,
        Examples\Commands\Init\SetGetStartedCommand::class,
    ]);

    $messenger_bot->commandBus()->addPostbackCommands([
        Examples\Commands\Postback\StartCommand::class,
        MBoretto\MessengerBot\Commands\StartCommand::class,
    ]);

    $messenger_bot->commandBus()->addWebhookCommands([
        Examples\Commands\GenericPostbackCommand::class,
        Examples\Commands\GenericMessageCommand::class,
    ]);

    $request = Request::createFromGlobals();
    $messenger_bot->handle($request);
} catch (MBoretto\MessengerBot\Exception\MessengerException $e) {
    // Silence is golden!
    file_put_contents('error.log', $e, FILE_APPEND);
    //echo $e;
}
