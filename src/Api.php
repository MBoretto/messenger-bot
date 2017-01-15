<?php

namespace MBoretto\MessengerBot;

define('BASE_PATH', __DIR__);

use MBoretto\MessengerBot\Commands\CommandBus;
use MBoretto\MessengerBot\Exception\MessengerException;
use MBoretto\MessengerBot\Objects\Update;
use MBoretto\MessengerBot\Objects\Messaging;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class Api
{
    /**
     * Version
     * @var string
     */
    protected $version = '0.0.6';

    /**
     * Messenger graph path
     * @var string
     */
    protected $graph_path = 'https://graph.facebook.com/v2.8';

    /**
     * Messenger Bot Token
     * @var string
     */
    protected $token = '';

    /**
     * Messenger Bot Verify Token
     * @var string
     */
    protected $verify_token = '';

    /**
     * Messenger Bot name
     * @var string
     */
    protected $bot_name = '';

    /**
     * Command bus
     * @var null|CommandBus
     */
    protected $command_bus = null;

    /**
     * Guzzle Cliet
     * @var null|Client
     */
    protected $client = null;

    /**
     * Request
     * @var null|Request
     */
    protected $request = null;

    /**
     * Messenger constructor.
     * @param string $api_key
     * @param string $verify_token
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
     * @return string
     * @throws MessengerException;
     */
    public function handleSetWebhook()
    {
        $hub_challenge = $this->request->query->get('hub_challenge');
        if ($this->request->query->get('hub_mode') == 'subscribe' && $hub_challenge !== null) {
            if ($this->request->query->get('hub_verify_token') == $this->verify_token) {
                echo $hub_challenge;
                sleep(1);
                $this->commandBus()->handleAllInitCommands();
                return;
            } else {
                echo "error verify token didn't match ";
                return;
            }
        }
        echo "error hub_challenge is null ";
        return;
    }

    /*
     * Handle Facebook Request
     * @param Request $request http request
     * @return bool
     * @throws MessengerException;
     */
    public function handleRequest()
    {
        $payload = $this->request->getContent();

        $update = new Update(json_decode($payload, true));
        foreach ($update->getEntry() as $entry) {
            foreach ($entry->getMessaging() as $messaging) {
                $this->commandBus()->handler($messaging);
            }
        }
    }

    /**
     * Handle bot request from webhook
     * @param Request $request http request
     * @return bool
     * @throws MessengerException;
     */
    public function handle(Request $request)
    {
        $this->setRequest($request);
        if (!is_null($request->query->get('hub_mode'))) {
            return $this->handleSetWebhook();
        }
        return $this->handleRequest();
    }

    /**
     * Send message.
     * @throws MessengerResponseException;
     * @todo
     * @return bool
     */
    public function sendMessage(Messaging $messaging)
    {
        //For plain messages
        if (!is_null($messaging->getMessage())) {
            $message = $messaging->getMessage();
            $text = $message->getText();
            if (!is_null($text)) {
                $string_len_utf8 = mb_strlen($text, 'UTF-8');
                //Check if I exeed the maximum size if was i split the message
                if ($string_len_utf8 > 640) {
                    $message->setText(mb_substr($text, 0, 640));
                    $messaging->setMessage($message);
                    $this->send('messages', $messaging);

                    $message->setText(mb_substr($text, 640, $string_len_utf8));
                    $messaging->setMessage($message);
                    return $this->sendMessage($messaging);
                }
            }
        }
        return $this->send('messages', $messaging);
    }

    /**
     * Send thread settings.
     * @throws MessengerResponseException;
     * @todo
     * @return bool
     */
    public function sendThreadSetting($data)
    {
        return $this->send('thread_settings', $data);
    }

    /**
     * Send request.
     * @throws MessengerResponseException;
     * @todo
     * @return bool
     */
    protected function send($action, $json_payload)
    {
        try {
            return $this->getClient()->post(
                $this->graph_path . '/me/' . $action . '?access_token=' . $this->token,
                [
                    'headers' => ['Content-Type' => 'application/json'],
                    'body' => $json_payload,
                    //'debug' => true
                ]
            );
        } catch (GuzzleHttp\Exception\ClientException $e) {
            throw new MessengerResponseException($e);
        }
    }

    /**
     * Get user info.
     * @throws MessengerResponseException;
     * @return string
     */
    public function getUser($user_id, $fields = ['first_name', 'last_name', 'profile_pic', 'locale', 'timezone', 'gender'])
    {
        try {
            $response = $this->getClient()->get(
                $this->graph_path . '/' . $user_id,
                ['query' => [
                    'fields' => implode(',', $fields),
                    'access_token' => $this->token
                    ]
                ]
            );

            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $e) {
            throw new MessengerResponseException($e);
        }
    }

    /**
     * Return the messenger token.
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the http request
     * @param Request $request http request
     * @return Api
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }
}
