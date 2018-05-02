<?php

namespace Najaram\Zomatotoy;

use GuzzleHttp\Client;
use Najaram\Zomatotoy\Zomatotoy;
use Najaram\Zomatotoy\Exceptions\CouldNotZomatotoy;

class Zomatoy
{   
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var Zomatotoy
     */
    protected $zomatotoy;

    /**
     * Constructor
     * 
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        if (!isset($apiKey)) {
            throw CouldNotZomatotoy::noApiKey();
        }

        $this->zomatotoy = new Zomatotoy();
        $this->zomatotoy->setApiKey($apiKey);
    }

    /**
     * Get the result of an api call
     * 
     * @param string $endpoint
     * @param array $args
     */
    public function get(string $endpoint, array $args = [])
    {
        $result = $this->zomatotoy->get($endpoint, $args);

        return $result;
    }

}
