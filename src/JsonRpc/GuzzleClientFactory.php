<?php declare(strict_types=1);

namespace Achse\GethJsonRpcPhpClient\JsonRpc;

use GuzzleHttp\Client as GuzzleHttpClient;
use Nette\SmartObject;



class GuzzleClientFactory
{
	use SmartObject;

	/**
	 * @param string[] $options
	 * @return GuzzleHttpClient
	 */
    public function create(array $options): GuzzleHttpClient
	{
		return new GuzzleHttpClient($options);
	}

}
