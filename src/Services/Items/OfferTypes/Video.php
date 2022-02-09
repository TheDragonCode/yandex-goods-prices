<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes;

use Helldar\Yandex\GoodsPrices\Helpers\Variables;
use Illuminate\Validation\Rule;
use function date;
use function implode;
use function is_array;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__artist-title
 */
class Video extends BaseType
{
    protected $type = 'artist.title';

    public function __construct()
    {
        $this->requiredItems('delivery', 'title');
    }

    public function title(string $value): self
    {
        $this->addItem('title', $value);

        return $this;
    }

    /**
     * @param array|string $values
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Video
     */
    public function starring($values): self
    {
        $values = is_array($values) ? implode(', ', $values) : $values;

        $this->addItem('starring', $values);

        return $this;
    }

    public function director(string $value): self
    {
        $this->addItem('director', $value);

        return $this;
    }

    public function originalName(string $value): self
    {
        $this->addItem('originalName', $value);

        return $this;
    }

    public function country(string $value): self
    {
        $this->addItem('country', $value);

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

    public function adult(bool $is_adult): self
    {
        $is_adult = $is_adult ? 'true' : 'false';

        $this->addItem('adult', $is_adult);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'title'        => ['string', 'max:255'],
            'starring'     => ['string'],
            'director'     => ['string', 'max:255'],
            'originalName' => ['string', 'max:255'],
            'country'      => ['string', 'max:255', Rule::in(Variables::COUNTRIES)],
            'year'         => ['integer', 'max:' . date('Y')],
            'media'        => ['string', 'max:255'],
            'adult'        => ['string', 'max:255', Rule::in(Variables::BOOLEAN)],
        ];
    }
}
