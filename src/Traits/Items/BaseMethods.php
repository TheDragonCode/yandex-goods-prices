<?php

namespace Helldar\Yandex\GoodsPrices\Traits\Items;

use Helldar\Yandex\GoodsPrices\Helpers\Variables;
use Illuminate\Validation\Rule;

trait BaseMethods
{
    public function url(string $url): self
    {
        $rules = ['required', 'url', 'max:512'];
        $this->addItem('url', $url, $rules);

        return $this;
    }

    public function price(int $value): self
    {
        $rules = ['required', 'integer', 'min:1'];

        $this->addItem('price', $value, $rules);

        return $this;
    }

    public function currencyId(string $value): self
    {
        $rules = ['required', 'string', Rule::in(Variables::CURRENCIES)];

        $this->addItem('currencyId', $value, $rules);

        return $this;
    }

    public function categoryId(int $value): self
    {
        $rules = ['required', 'integer', 'max:999999999999999999'];

        $this->addItem('categoryId', $value, $rules);

        return $this;
    }

    public function delivery(bool $value): self
    {
        $value = $value ? 'true' : 'false';
        $rules = ['string', Rule::in(Variables::BOOLEAN)];

        $this->addItem('delivery', $value, $rules);

        return $this;
    }
}
