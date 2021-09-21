<?php declare(strict_types=1);

namespace Achse\GethJsonRpcPhpClient;

use Nette\SmartObject;
use function bcadd;
use function bcmul;
use function bcpow;


class Utils
{
	use SmartObject;

	/**
	 * @see http://stackoverflow.com/questions/1273484/large-hex-values-with-php-hexdec
	 *
	 * @param string $hex
	 * @return string
	 */
	public static function bigHexToBigDec(string $hex): string
    {
		$dec = '0';
		$len = \strlen($hex);
		for ($i = 1; $i <= $len; $i++) {
			$dec = bcadd($dec, bcmul(\strval(hexdec($hex[$i - 1])), bcpow('16', \strval($len - $i))));
		}

		return $dec;
	}

}
