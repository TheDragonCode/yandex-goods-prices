<?php

namespace Helldar\Yandex\GoodsPrices\Traits;

use Helldar\Yandex\GoodsPrices\Exceptions\YandexGoodsPricesException;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use function array_merge;
use function array_push;
use function array_unique;
use function in_array;

trait Validator
{
    protected function validate(array $data = [], array $rules = [], array $base_rules = [], array $required_items = [])
    {
        $rules = array_merge($base_rules, $rules);

        foreach ($rules as $key => &$values) {
            if (in_array($key, $required_items)) {
                array_push($values, 'required');

                $values = array_unique($values);
            }
        }

        $validator = IlluminateValidator::make($data, $rules);

        if ($validator->fails()) {
            throw new YandexGoodsPricesException($validator->errors()->first());
        }
    }
}
