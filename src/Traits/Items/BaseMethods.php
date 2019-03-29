<?php

namespace Helldar\Yandex\GoodsPrices\Traits\Items;

trait BaseMethods
{
    public function id(int $id): self
    {
        $this->addItem('id', $id);

        return $this;
    }

    public function available(bool $is_available): self
    {
        $value = $is_available ? 'true' : 'false';

        $this->addItem('available', $value);

        return $this;
    }

    public function url(string $url): self
    {
        $this->addItem('url', $url);

        return $this;
    }

    public function price(int $value): self
    {
        $this->addItem('price', $value);

        return $this;
    }

    public function currencyId(string $value): self
    {
        $this->addItem('currencyId', $value);

        return $this;
    }

    public function categoryId(int $value): self
    {
        $this->addItem('categoryId', $value);

        return $this;
    }

    public function delivery(bool $value): self
    {
        $value = $value ? 'true' : 'false';

        $this->addItem('delivery', $value);

        return $this;
    }
}
