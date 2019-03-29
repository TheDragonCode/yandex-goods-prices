<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items;

use Helldar\Yandex\GoodsPrices\Services\Items\Types\AudioBook;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Book;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Music;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Other;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Tour;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Video;

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

    public function video(): Video
    {
        return new Video;
    }

    public function tour(): Tour
    {
        return new Tour;
    }
}
