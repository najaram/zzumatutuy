<?php

namespace Najaram\Zomatotoy\Tests;

use GuzzleHttp\Client;
use Najaram\Zomatotoy\Zomatotoy;
use Najaram\Zomatotoy\Exceptions\CouldNotZomatotoy;

class ZomatotoyTest extends TestCase
{
	/** @var Zomatotoy */
	protected $subject;

	public function setUp()
	{
		parent::setUp();

		$this->subject = new Zomatotoy(new Client());
		$this->subject->setApiKey(getenv('API_KEY'));
	}

	/** @test */
	public function it_can_be_initialized()
	{
		$this->assertInstanceOf(Zomatotoy::class, $this->subject);
	}
	
	/** @test */
	public function missing_required_params()
	{
		$zomatotoy = $this->getMockBuilder(Zomatotoy::class)
			->setMethods(['get'])
			->getMock();

		$zomatotoy
			->expects($this->once())
			->method('get')
			->with($this->equalTo('something'));

		$zomatotoy->get('something', []);
	}

	/** @test */
	public function geocode_should_return_data()
	{
		$endPoint = 'geocode';
		
		$args = [
			'lat' => 14.32,
			'lon' => 121.1
		];

		$response = $this->subject->get($endPoint, $args);

		$this->assertArrayHasKey('location', $response);
		$this->assertArrayHasKey('popularity', $response);
	}

}