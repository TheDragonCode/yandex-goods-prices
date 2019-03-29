<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use DOMElement;
use Helldar\Core\Xml\Helpers\Str;
use Helldar\Yandex\GoodsPrices\Interfaces\XmlItems;
use Helldar\Yandex\GoodsPrices\Traits\Xml;

class Category implements XmlItems
{
    use Xml;

    private $id;

    private $name;

    public function id(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function name(string $value): self
    {
        $this->name = \trim($value);

        return $this;
    }

    public function get(): DOMElement
    {
        $name       = 'category';
        $attributes = ['id' => $this->id];
        $value      = Str::e($this->name);

        return $this->xmlItem($name, $value, $attributes);
    }
}
