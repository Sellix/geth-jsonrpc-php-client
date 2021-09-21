<?php declare(strict_types=1);

namespace Achse\GethJsonRpcPhpClient\Tests\Unit\JsonRpc;

require_once __DIR__ . '/../../bootstrap.php';

use Achse\GethJsonRpcPhpClient\JsonRpc\GuzzleClient;
use Achse\GethJsonRpcPhpClient\JsonRpc\GuzzleClientFactory;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Mockery;
use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tester\Environment;
use Tester\TestCase;



class GuzzleClientTest extends TestCase
{

	public function testGuzzlePost(): void
    {
		$factory = $this->mockFactory('{}');
		$guzzle = new GuzzleClient($factory, 'localhost', 12345);
		$guzzle->post('{}');

		Environment::$checkAssertions = FALSE;
	}



	/**
	 * @param string $result
	 * @return GuzzleClientFactory&MockInterface
	 */
	private function mockFactory($result): GuzzleClientFactory
	{
		return Mockery::mock(GuzzleClientFactory::class)
			->shouldReceive('create')->andReturn($this->mockGuzzleClient($result))->getMock();
	}



	/**
	 * @param string $result
	 * @return GuzzleHttpClient&MockInterface
	 */
	private function mockGuzzleClient(string $result)
	{
		return Mockery::mock(GuzzleHttpClient::class)
			->shouldReceive('post')->andReturn(
				Mockery::mock(ResponseInterface::class)
					->shouldReceive('getBody')->andReturn(
						Mockery::mock(StreamInterface::class)
							->shouldReceive('getContents')->andReturn($result)->getMock()
					)->getMock()
			)->getMock();
	}



	/**
	 * @throws \Achse\GethJsonRpcPhpClient\JsonRpc\RequestFailedException
	 */
	public function testGuzzleFail(): void
    {
		$factory = $this->mockFactoryFailRequest();
		$guzzle = new GuzzleClient($factory, 'localhost', 12345);
		$guzzle->post('{}');

		Environment::$checkAssertions = FALSE;
	}



	/**
	 * @return GuzzleClientFactory&MockInterface
	 */
	private function mockFactoryFailRequest(): GuzzleClientFactory
	{
		return Mockery::mock(GuzzleClientFactory::class)
			->shouldReceive('create')->andReturnUsing(
				function () {
					throw Mockery::mock(RequestException::class);
				}
			)->getMock();
	}

}



(new GuzzleClientTest())->run();
