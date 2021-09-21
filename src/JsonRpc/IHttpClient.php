<?php declare(strict_types=1);

namespace Achse\GethJsonRpcPhpClient\JsonRpc;



interface IHttpClient
{

	/**
	 * @param string $body
	 * @return string
	 * @throws RequestFailedException
	 */
	public function post(string $body): string;

}
