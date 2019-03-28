<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use DOMElement;
use Helldar\Yandex\GoodsPrices\Interfaces\XmlItems;
use Helldar\Yandex\GoodsPrices\Traits\Xml;

class Offer implements XmlItems
{
    use Xml;

    private $id;

    private $available = 'true';

    private $url;

    private $price;

    private $currency_id;

    private $category_id;

    private $delivery = 'false';

    private $name;

    public function id(string $id): self
    {
        $this->id = \trim((string) $id);

        return $this;
    }

    public function available(bool $value): self
    {
        $this->available = $value ? 'true' : 'false';

        return $this;
    }

    public function url(string $value): self
    {
        $this->url = $value;

        return $this;
    }

    public function price(float $value): self
    {
        $this->price = $value;

        return $this;
    }

    public function currencyId(int $id): self
    {
        $this->currency_id = $id;

        return $this;
    }

    public function categoryId(int $id): self
    {
        $this->category_id = $id;

        return $this;
    }

    public function delivery(bool $value): self
    {
        $this->delivery = $value ? 'true' : 'false';

        return $this;
    }

    public function name(string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function get(): DOMElement
    {
        $offer = $this->makeOffer();

        $url   = $this->xmlItem('url', $this->url);
        $price = $this->xmlItem('price', $this->price);
        $name  = $this->xmlItem('name', $this->name);

        $currency_id = $this->xmlItem('currencyId', $this->currency_id);
        $category_id = $this->xmlItem('categoryId', $this->category_id);

        $delivery = $this->xmlItem('delivery', $this->delivery);

        $this->xmlAppendChild($offer, $category_id);
        $this->xmlAppendChild($offer, $currency_id);
        $this->xmlAppendChild($offer, $delivery);
        $this->xmlAppendChild($offer, $name);
        $this->xmlAppendChild($offer, $price);
        $this->xmlAppendChild($offer, $url);

        return $offer;
    }

    private function makeOffer(): DOMElement
    {
        $id        = $this->id;
        $available = $this->available;

        return $this->xmlItem('offer', null, \compact('id', 'available'));
    }
}
