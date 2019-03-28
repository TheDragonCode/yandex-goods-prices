<?php

namespace Helldar\Yandex\GoodsPrices\Interfaces;

use DOMElement;

interface XmlItems
{
    public function get(): DOMElement;
}
