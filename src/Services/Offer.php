<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use DOMElement;
use Helldar\Core\Xml\Helpers\Str;
use Helldar\Yandex\GoodsPrices\Interfaces\XmlItems;
use Helldar\Yandex\GoodsPrices\Traits\Validator;
use Helldar\Yandex\GoodsPrices\Traits\Xml;

class Offer implements XmlItems
{
    use Xml, Validator;

    private $id;

    private $type;

    private $available = 'true';

    private $url;

    private $price;

    private $currency_id;

    private $category_id;

    private $delivery = 'false';

    private $name;

    private $description;

    public function id(int $id): self
    {
        $this->validate(\compact('id'), [
            'id' => ['required', 'min:1'],
        ]);

        $this->id = $id;

        return $this;
    }

    public function type(string $value = null): self
    {
        $this->validate(\compact('value'), [
            'value' => ['nullable', 'string'],
        ]);

        $this->type = \is_null($value) ? null : \trim($value);

        return $this;
    }

    public function available(bool $value): self
    {
        $this->available = $value ? 'true' : 'false';

        return $this;
    }

    public function url(string $url): self
    {
        $this->validate(\compact('url'), [
            'url' => ['required', 'url'],
        ]);

        $this->url = Str::e($url);

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
        $value = \strip_tags($value);

        $this->name = Str::e(\trim($value));

        return $this;
    }

    public function description(string $value): self
    {
        $value = \strip_tags($value);

        $this->description = Str::e(\trim($value));

        return $this;
    }

    public function get(): DOMElement
    {
        $offer = $this->makeOffer();

        $url         = $this->xmlItem('url', $this->url);
        $price       = $this->xmlItem('price', $this->price);
        $name        = $this->xmlItem('name', $this->name);
        $description = $this->xmlItem('description', $this->description);

        $currency_id = $this->xmlItem('currencyId', $this->currency_id);
        $category_id = $this->xmlItem('categoryId', $this->category_id);

        $delivery = $this->xmlItem('delivery', $this->delivery);

        $this->xmlAppendChild($offer, $category_id);
        $this->xmlAppendChild($offer, $currency_id);
        $this->xmlAppendChild($offer, $delivery);
        $this->xmlAppendChild($offer, $name);
        $this->xmlAppendChild($offer, $description);
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
