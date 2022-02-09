<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes;

use function date;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__book
 */
class Book extends BaseType
{
    protected $type = 'book';

    public function __construct()
    {
        $this->requiredItems('delivery', 'name');
    }

    public function author(string $value): self
    {
        $this->addItem('author', $value);

        return $this;
    }

    public function name(string $value): self
    {
        $this->addItem('name', $value);

        return $this;
    }

    public function publisher(string $value): self
    {
        $this->addItem('publisher', $value);

        return $this;
    }

    public function series(string $value): self
    {
        $this->addItem('series', $value);

        return $this;
    }

    public function year(int $value): self
    {
        $this->addItem('year', $value);

        return $this;
    }

    public function isbn(string $value): self
    {
        $this->addItem('ISBN', $value);

        return $this;
    }

    public function description(string $value): self
    {
        $this->addItem('description', $value);

        return $this;
    }

    public function volume(int $value): self
    {
        $this->addItem('volume', $value);

        return $this;
    }

    public function part(int $value): self
    {
        $this->addItem('part', $value);

        return $this;
    }

    public function language(string $value): self
    {
        $this->addItem('language', $value);

        return $this;
    }

    public function binding(string $value): self
    {
        $this->addItem('binding', $value);

        return $this;
    }

    public function pageExtent(int $value): self
    {
        $this->addItem('page_extent', $value);

        return $this;
    }

    public function tableOfContents(string $value): self
    {
        $this->addItem('table_of_contents', $value);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'author'      => ['string', 'max:255'],
            'name'        => ['string', 'max:255'],
            'publisher'   => ['string', 'max:255'],
            'series'      => ['string', 'max:255'],
            'year'        => ['integer', 'max:' . date('Y')],
            'ISBN'        => ['string'],
            'description' => ['string', 'max:175'],
            'volume'      => ['integer', 'min:0', 'required_with:part', 'gte:part'],
            'part'        => ['integer', 'min:0', 'required_with:volume'],
            'language'    => ['string', 'max:255'],
            'binding'     => ['string', 'max:255'],
            'page_extent' => ['integer', 'min:1'],

            'table_of_contents' => ['string'],
        ];
    }
}
