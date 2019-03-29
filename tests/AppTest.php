<?php

namespace Tests;

use Helldar\Yandex\GoodsPrices\Services\Items\Category;
use Helldar\Yandex\GoodsPrices\Services\Items\Currency;
use Helldar\Yandex\GoodsPrices\Services\Items\Offer;
use Helldar\Yandex\GoodsPrices\Services\Service;

class AppTest extends TestCase
{
    public function testFacade()
    {
        $service  = \app('yandex_goods_prices')->service();
        $category = \app('yandex_goods_prices')->category();
        $currency = \app('yandex_goods_prices')->currency();
        $offer    = \app('yandex_goods_prices')->offer();

        $this->assertTrue($service instanceof Service);
        $this->assertTrue($category instanceof Category);
        $this->assertTrue($currency instanceof Currency);
        $this->assertTrue($offer instanceof Offer);
    }
}
