<?php

namespace Helldar\Yandex\GoodsPrices\Traits;

use Helldar\Yandex\GoodsPrices\Exceptions\YandexGoodsPricesException;
use Illuminate\Support\Facades\Validator as IlluminateValidator;

trait Validator
{
    protected function validate(array $data = [], array $rules = [])
    {
        $validator = IlluminateValidator::make($data, $rules);

        if ($validator->fails()) {
            throw new YandexGoodsPricesException($validator->errors()->first());
        }
    }
}
