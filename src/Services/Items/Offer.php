<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items;

use Helldar\Yandex\GoodsPrices\Services\Items\Types\AudioBook;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Book;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Music;
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

    public function audioBook(): AudioBook
    {
        return new AudioBook;
    }

    public function music(): Music
    {
        return new Music;
    }
}
