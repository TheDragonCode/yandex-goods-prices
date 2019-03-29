<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items;

use Helldar\Yandex\GoodsPrices\Services\Items\Types\Book;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Other;

class Offer
{
    public function other(): Other
    {
        return new Other;
    }

    public function book(): Book
    {
        return new Book;
    }
}
