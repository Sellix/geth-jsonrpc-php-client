<?php declare(strict_types=1);

namespace Achse\GethJsonRpcPhpClient\Tests\Unit\JsonRpc;

require_once __DIR__ . '/../../bootstrap.php';

use Achse\GethJsonRpcPhpClient\JsonRpc\GuzzleClientFactory;
use GuzzleHttp\Client as GuzzleHttpClient;
use Tester\Assert;
use Tester\TestCase;



class GuzzleClientFactoryTest extends TestCase
{

	public function testCreate(): void
    {
		$factory = new GuzzleClientFactory();
		Assert::type(GuzzleHttpClient::class, $factory->create([]));
	}

}



(new GuzzleClientFactoryTest())->run();
