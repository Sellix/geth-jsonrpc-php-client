<?php declare(strict_types=1);

namespace Achse\GethJsonRpcPhpClient\JsonRpc;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;



class GuzzleClient implements IHttpClient
{

	/**
	 * @var GuzzleHttpClient|NULL
	 */
	private $client;

	/**
	 * @var string[]
	 */
	private $options;

	/**
	 * @var GuzzleClientFactory
	 */
	private $guzzleClientFactory;



	/**
	 * @param GuzzleClientFactory $guzzleClientFactory
	 * @param string $url
	 * @param int|null $port
	 */
	public function __construct(GuzzleClientFactory $guzzleClientFactory, string $url, ?int $port = null)
	{
		$this->guzzleClientFactory = $guzzleClientFactory;

		$this->options = [
			'base_uri' => $port !== null ? sprintf('%s:%d', $url, $port) : $url,
		];
	}



	/**
	 * @inheritdoc
	 */
	public function post(string $body): string
	{
		try {
			$this->openClient();
			\assert($this->client !== NULL);
			$response = $this->client->post('', ['body' => $body, 'headers' => ['Content-Type' => 'application/json']]);
		} catch (RequestException $exception) {
			throw new RequestFailedException(
				sprintf('Request failed due to Guzzle exception: "%s".', $exception->getMessage()),
				$exception->getCode(),
				$exception
			);
		}

		return $response->getBody()->getContents();
	}



	private function openClient(): void
    {
		if ($this->client === NULL) {
			$this->client = $this->guzzleClientFactory->create($this->options);
		}
	}

}
