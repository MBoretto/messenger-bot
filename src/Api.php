<?php

namespace MBoretto\MessengerBot;

define('BASE_PATH', __DIR__);

use MBoretto\MessengerBot\Commands\CommandBus;
use MBoretto\MessengerBot\Exception\MessengerException;
use MBoretto\MessengerBot\Objects\Update;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class Api
{
    /**
     * Version
     *
     * @var string
     */
    protected $version = '0.0.1';

    /**
     * Messenger Bot Token
     *
     * @var string
     */
    protected $token = '';

    /**
     * Messenger Bot Verify Token
     *
     * @var string
     */
    protected $verify_token = '';

    /**
     * Messenger Bot name
     *
     * @var string
     */
    protected $bot_name = '';

    /**
     * Command bus
     *
     * @var null|CommandBus
     */
    protected $command_bus = null;

    /**
     * Guzzle Cliet
     *
     * @var null|Client
     */
    protected $client = null;

    /**
     * Request
     *
     * @var null|Request
     */
    protected $request = null;

    /**
     * Messenger constructor.
     *
     * @param string $api_key
     * @param string $verify_token
     *
     * @throws MessengerException;
     */
    public function __construct($token, $verify_token)
    {
        if (empty($token)) {
            throw new MessengerException('Token not defined!');
        }

        if (empty($verify_token)) {
            throw new MessengerException('Verify Token not defined!');
        }
        $this->token = $token;
        $this->verify_token = $verify_token;
        $this->command_bus = new CommandBus($this);
    }

    /**
     * Create/Return the Guzzle client
     *
     * @return Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            return new Client();
        }
        return $this->client;
    }

    /**
     * Return CommandBus.
     *
     * @return CommandBus
     * @todo
     * @throws MessengerException;
     */
    public function commandBus()
    {
        return $this->command_bus;
    }

    /*
     * Handle request to set up the webhook
     *
     * @param Request $request http request
     *
     * @return bool
     *
     * @throws MessengerException;
     */
    public function handleSetWebhook()
    {
        $hub_challenge = $this->request->has('hub_challenge') ? $this->request->query->get('hub_challenge') : null;
        if ($this->request->query->get('hub_mode') == 'subscribe' && $hub_challenge !== null) {
            if ($this->request->query->get('hub_verify_token') == $this->verify_token) {
                echo $hub_challenge;
                $this->commandBus()->handleAllInitCommands();
            } else {
                echo "error verify token didn't match ";
            }
        }
    }

    /*
     * Handle Facebook Request
     *
     * @param Request $request http request
     *
     * @return bool
     *
     * @throws MessengerException;
     */
    public function handleRequest()
    {
        $payload = $this->request->getContent();
//
//        //Get startwd
//        $payload = '{"object":"page","entry":[{"id":"496739423863385","time":1476738772815,"messaging":[{"recipient":{"id":"496739423863385"},"timestamp":1476738772815,"sender":{"id":"1193858294006371"},"postback":{"payload":"my_payload"}}]}]}';
//
//        //Update coming from a post back button
//        $payload = '{"object":"page","entry":[{"id":"496739423863385","time":1476652519480,"messaging":[{"recipient":{"id":"496739423863385"},"timestamp":1476652519480,"sender":{"id":"1193858294006371"},"postback":{"payload":"start"}}]}]}';
//        //Update coming from a plain text
//        $payload = '{"object":"page","entry":[{"id":"496739423863385","time":1475364618006,"messaging":[{"sender":{"id":"1193858294006371"},"recipient":{"id":"496739423863385"},"timestamp":1475364617920,"message":{"mid":"mid.1475364617907:fb4766a132180f3257","seq":73,"text":"Ggg"}}]}]}';




        //if (!empty($payload)) {
            $update = new Update(json_decode($payload, true));
            foreach ($update->getEntry() as $entry) {
                foreach ($entry->getMessaging() as $messaging) {
                    //$this->commandBus()->handleAllInitCommands();
                    $this->commandBus()->handler($messaging);
                }
            }
            file_put_contents('/data/grocerylist/storage/logs/request.log', $payload . "\n", FILE_APPEND);
        //}
    }

    /**
     * Handle bot request from webhook
     *
     * @param Request $request http request
     *
     * @return bool
     *
     * @throws MessengerException;
     */
    public function handle(Request $request)
    {
        $this->setRequest($request);
        if ($request->has('hub_mode')) {
            return $this-handleSetWebhook();
        }
        return $this-handleRequest();
    }

    /**
     * Send message.
     *
     * @return bool
     *
     * @throws MessengerException;
     */
    public function sendMessage($data)
    {
        return $this->send('messages', $data);
    }

    /**
     * Send thread settings.
     *
     * @return bool
     */
    public function sendThreadSetting($data)
    {
        return $this->send('thread_settings', $data);
    }

    /**
     * send request.
     * @todo
     * @return bool
     */
    protected function send($action, $json_payload)
    {
        //echo $json_payload;
        $client = $this->getClient();
        return $client->post(
            'https://graph.facebook.com/v2.6/me/' . $action . '?access_token=' . $this->token,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $json_payload,
                //'debug' => true
            ]
        );
    }

    /**
     * get user info.
     *
     * @return bool
     */
    protected function get($user_id, $fields = ['first_name', 'last_name', 'profile_pic', 'locale', 'timezone', 'gender'])
    {
        $client = $this->getClient();
        $response = $client->get(
            'https://graph.facebook.com/v2.6/' . $user_id,
            ['query' => [
                'fields' => implode(',', $fields),
                'access_token' => $this->token
                ]
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * Return the messenger token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the http request
     *
     * @param Request $request http request
     *
     * @return Api
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }
}
