<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes;

use function strip_tags;

/**
 * Made according to the recommendations of the CEO specialist.
 */
class WithoutType extends BaseType
{
    protected $type = null;

    public function __construct()
    {
        $this->requiredItems('delivery');
    }

    /**
     * @param string $value
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\WithoutType
     */
    public function name(string $value): self
    {
        $this->addItem('name', strip_tags($value));

        return $this;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
