<?php

// Load composer
require __DIR__ . '/vendor/autoload.php';

// Add you bot's token and verify_token
$TOKEN = 'your_bot_token';
$VERIFY_TOKEN = 'your_bot_token';

use MBoretto\MessengerBot\Exception\MessengerException;

try {
    // Create Telegram API object
    $messenger_bot = new MBoretto\MessengerBot\Api($TOKEN, $VERIFY_TOKEN);
    $messenger_bot->handle();
} catch (MBoretto\MessengerBot\Exception\MessengerException $e) {
    // Silence is golden!
    file_put_contents('error.log', $e, FILE_APPEND);
    //echo $e;
}
