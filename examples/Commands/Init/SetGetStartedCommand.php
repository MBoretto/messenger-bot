<?php

namespace Examples\Commands\Init;

use MBoretto\MessengerBot\Commands\Command;
use MBoretto\MessengerBot\Objects\Messaging;
use MBoretto\MessengerBot\ThreadSettings\GetStarted;

class SetGetStartedCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "setgetstartedbutton";

    /**
     * @var string Command Description
     */
    protected $description = "set get started button";

    /**
     * @inheritdoc
     */
    public function handle(Messaging $messaging = null)
    {
        //set GetStarted button
        $data = new GetStarted();
        $data->setCallToActions([['payload' => 'start']]);

        $client = new \GuzzleHttp\Client();
        $page_id = '496739423863385';
        $action = 'thread_settings';
        $client->post(
            'https://graph.facebook.com/v2.6/'. $page_id . '/' . $action . '?access_token=' . $messenger->getToken(),
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $data->toJson(),
                //'debug' => true
            ]
        );
        //$this->getMessenger()->sendThreadSetting($data->toJson());
    }
}
