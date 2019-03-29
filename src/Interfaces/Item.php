<?php

namespace Helldar\Yandex\GoodsPrices\Interfaces;

use DOMElement;

interface Item
{
    public function get(): DOMElement;
}
