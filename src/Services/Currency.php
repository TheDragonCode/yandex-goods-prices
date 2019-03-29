<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use DOMElement;
use Helldar\Core\Xml\Helpers\Str;
use Helldar\Yandex\GoodsPrices\Helpers\CurrencyHelper;
use Helldar\Yandex\GoodsPrices\Interfaces\XmlItems;
use Helldar\Yandex\GoodsPrices\Traits\Validator;
use Helldar\Yandex\GoodsPrices\Traits\Xml;
use Illuminate\Validation\Rule;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#concept3__currencies
 */
class Currency implements XmlItems
{
    use Xml, Validator;

    private $id = 'RUB';

    private $rate = 'СВ';

    public function id(string $id = 'RUB'): self
    {
        $id = Str::upper(\trim($id));

        $this->validate(\compact('id'), [
            'id' => ['string', Rule::in(CurrencyHelper::AVAILABLE_CURRENCIES)],
        ]);

        $this->id = $id;

        return $this;
    }

    /**
     * @param string|float $rate
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\Currency
     */
    public function rate($rate = 'СВ'): self
    {
        if (!\is_numeric($rate)) {
            $rate = Str::upper($rate);

            $this->validate(\compact('rate'), [
                'rate' => ['string', Rule::in(CurrencyHelper::AVAILABLE_RATE)],
            ]);
        }

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
