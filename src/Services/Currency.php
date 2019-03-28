<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use DOMElement;
use Helldar\Yandex\GoodsPrices\Interfaces\XmlItems;
use Helldar\Yandex\GoodsPrices\Traits\Xml;

class Currency implements XmlItems
{
    use Xml;

    private $id = 'RUR';

    private $rate = 1;

    public function id(string $id = 'RUR'): self
    {
        $this->id = $id;

        return $this;
    }

    public function rate(int $rate = 1): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function get(): DOMElement
    {
        $name = 'currency';

        $attributes = [
            'id'   => $this->id,
            'rate' => $this->rate,
        ];

        return $this->xmlItem($name, null, $attributes);
    }
}
