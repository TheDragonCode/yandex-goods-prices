<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes;

use Helldar\Yandex\GoodsPrices\Helpers\Variables;
use Illuminate\Validation\Rule;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__tour
 */
class Tour extends BaseType
{
    protected $type = 'artist.title';

    public function __construct()
    {
        $this->requiredItems('delivery', 'days', 'name', 'included', 'transport');
    }

    public function worldRegion(string $value): self
    {
        $this->addItem('worldRegion', $value);

        return $this;
    }

    public function country(string $value): self
    {
        $this->addItem('country', $value);

        return $this;
    }

    public function region(string $value): self
    {
        $this->addItem('region', $value);

        return $this;
    }

    public function days(int $value): self
    {
        $this->addItem('days', $value);

        return $this;
    }

    public function dataTour(\DateTimeInterface $date): self
    {
        $this->addItem('dataTour', $date->format('Y-m-d'));

        return $this;
    }

    public function name(string $value): self
    {
        $this->addItem('name', $value);

        return $this;
    }

    public function hotelStars(int $value): self
    {
        $this->addItem('hotel_stars', $value);

        return $this;
    }

    public function room(string $value): self
    {
        $this->addItem('room', $value);

        return $this;
    }

    public function meal(string $value): self
    {
        $this->addItem('meal', $value);

        return $this;
    }

    public function included(string $value): self
    {
        $this->addItem('included', $value);

        return $this;
    }

    public function transport(string $value): self
    {
        $this->addItem('transport', $value);

        return $this;
    }

    public function description(string $value): self
    {
        $this->addItem('description', $value);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'worldRegion' => ['string', 'max:255'],
            'country'     => ['string', 'max:255', Rule::in(Variables::COUNTRIES)],
            'region'      => ['string', 'max:255'],
            'days'        => ['integer', 'min:1'],
            'dataTour'    => ['date'],
            'name'        => ['string', 'max:255'],
            'hotel_stars' => ['integer', 'min:1', 'max:5'],
            'room'        => ['string', 'max:255'],
            'meal'        => ['string', 'max:255'],
            'included'    => ['string', 'max:255'],
            'transport'   => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
        ];
    }
}
