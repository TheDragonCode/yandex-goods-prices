<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items;

use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\AudioBook;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Book;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\EventTicket;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Music;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Other;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Tour;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Video;

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

    public function eventTicket(): EventTicket
    {
        return new EventTicket;
    }
}
