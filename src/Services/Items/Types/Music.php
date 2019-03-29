<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\Types;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__artist-title
 */
class Music extends BaseType
{
    protected $type = 'artist.title';

    public function __construct()
    {
        $this->requiredItems('delivery', 'title');
    }

    public function artist(string $value): self
    {
        $this->addItem('artist', $value);

        return $this;
    }

    public function title(string $value): self
    {
        $this->addItem('title', $value);

        return $this;
    }

    public function year(int $value): self
    {
        $this->addItem('year', $value);

        return $this;
    }

    public function media(string $value): self
    {
        $this->addItem('media', $value);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'artist' => ['string', 'max:255'],
            'title'  => ['string', 'max:255'],
            'year'   => ['integer', 'max:' . \date('Y')],
            'media'  => ['string', 'max:255'],
        ];
    }
}
