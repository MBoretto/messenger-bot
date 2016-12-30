<?php
namespace MBoretto\MessengerBot\Exception;

/**
 * Main exception class used for exception handling
 */
class MessengerResponseException extends \Exception
{
    /**
     * Guzzle response
     * @var Object
     */
    protected $response;

    /**
     * MessengerResponseException constructor.
     * @param Object
     */
    public function __construct($e)
    {
        $this->response = $e->getResponse();
    }

    /**
     * Get guzzle reposponse
     * @return Object
     */
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * Get guzzle reposponse body
     * @return string
     */
    protected function getResponseBodyAsString()
    {
        return $this->response->getBody()->getContents();
    }
}
