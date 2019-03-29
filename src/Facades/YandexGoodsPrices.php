<?php

namespace Helldar\Yandex\GoodsPrices\Facades;

use Helldar\Yandex\GoodsPrices\Services\Items\Category;
use Helldar\Yandex\GoodsPrices\Services\Items\Currency;
use Helldar\Yandex\GoodsPrices\Services\Items\Offer;
use Helldar\Yandex\GoodsPrices\Services\Service;

class YandexGoodsPrices
{
    public function offer(): Offer
    {
        return new Offer;
    }

    public function category(): Category
    {
        return new Category;
    }

    public function currency(): Currency
    {
        return new Currency;
    }

    public function service(): Service
    {
        return new Service;
    }
}
