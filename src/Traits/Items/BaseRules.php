<?php

namespace Helldar\Yandex\GoodsPrices\Traits\Items;

use Helldar\Yandex\GoodsPrices\Helpers\Variables;
use Illuminate\Validation\Rule;

trait BaseRules
{
    protected function baseRules(): array
    {
        return [
            'id'         => ['required', 'integer', 'min:0'],
            'available'  => ['required', 'string', Rule::in(Variables::BOOLEAN)],
            'url'        => ['required', 'url', 'max:512'],
            'price'      => ['required', 'integer', 'min:1'],
            'currencyId' => ['required', 'string', Rule::in(Variables::CURRENCIES)],
            'categoryId' => ['required', 'integer'],
            'delivery'   => ['nullable', 'string', Rule::in(Variables::BOOLEAN)],
        ];
    }
}
