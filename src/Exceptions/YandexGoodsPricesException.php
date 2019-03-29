<?php

namespace Helldar\Yandex\GoodsPrices\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class YandexGoodsPricesException extends HttpException
{
    public function __construct($message = null, int $code = 400)
    {
        parent::__construct($code, $message, null, [], $code);
    }
}
