<?php

namespace Najaram\Zomatotoy;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Najaram\Zomatotoy\Exceptions\CouldNotZomatotoy;

class Zomatotoy
{
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var string
	 */
	protected $apiKey;

	/**
	 * @var array
	 */
	protected $paths = [
		'categories'        => [],
		'cities'            => [],
		'collections'       => [],
		'cuisines'          => [],
		'establishments'    => [],
		'geocode'           => ['lat', 'lon'],
		'location_details'  => ['entity_id', 'entity_type'],
		'locations'         => ['query'],
		'restaurant'        => ['res_id'],
		'reviews'           => ['res_id'],
		'search'            => [],
	];

	/**
	 * @var string
	 */
	protected $baseUrl = 'https://developers.zomato.com/api/v2.1';

	/**
	 * Constructor
	 * 
	 * @param Client $client
	 */
	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * Sets the api key
	 * 
	 * @param string $apiKey
	 */
	public function setApiKey(string $apiKey)
	{
		$this->apiKey = $apiKey;

	}

	/**
	 * Get the response
	 * 
	 * @param string $endPoint
	 * @param array $args
	 * @return mixed|null
	 */
	public function get(string $endPoint, array $args)
	{
		$endPoints = $this->checkEndpoint($endPoint);
		if (!$endPoints) {
			throw CouldNotZomatotoy::endpointError();
		}

		$arguments = $this->checkRequiredParams($endPoint, $args);
		if (!$arguments) {
			throw CouldNotZomatotoy::argsError();
		}

		$payload = $this->getPayload($args);

		$response = $this->client->request('GET', $this->baseUrl.'/'.$endPoint, $payload);

		return $this->responseReturn($response);

	}

	/**
	 * Returns the value
	 * 
	 * @param  Response $response
	 * @return mixed|null
	 */
	protected function responseReturn(Response $response)
	{
		if ($response->getStatusCode() !== 200) {
			throw CouldNotZomatotoy::couldNotConnect();
		}

		$result = json_decode($response->getBody(), true);

		return $result;
	}

	/**
	 * Sets the api key to the header(string)
	 * 
	 * @return array
	 */
	protected function getPayload(array $parameters): array
	{
		$data = [
			'query' => $parameters,
			'headers' => [
				'Accept' => 'application/json',
				'user-key' => $this->apiKey,
			]
		];

		return $data;
	}

	/**
	 * Checks if the required parameter is available.
	 * 
	 * @param string $endpoint
	 * @param array $args
	 * @return bool
	 */
	protected function checkRequiredParams(string $endPoint, array $args): bool
    {
		$pathArgs = $this->paths[$endPoint];

		foreach ($pathArgs as $pathArg) {
			if (!array_key_exists($pathArg, $args)) {
				return false;
			}
		} 

		return true;
	}
	
	/**
	 * Checks endpoint if exits.
	 * 
	 * @param string $endpoint
	 * @return bool
	 */
	protected function checkEndpoint(string $endpoint): bool
	{
		if (!array_key_exists($endpoint, $this->paths)) {
			return false;
		}

		return true;
	}
	
}