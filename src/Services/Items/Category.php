<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items;

use DOMElement;
use Helldar\Core\Xml\Helpers\Str;
use Helldar\Yandex\GoodsPrices\Interfaces\Item;
use Helldar\Yandex\GoodsPrices\Traits\Validator;
use Helldar\Yandex\GoodsPrices\Traits\Xml;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#concept3__categories
 */
class Category implements Item
{
    use Xml;
    use Validator;

    private $id;

    private $parentId;

    private $name;

    public function id(int $id): self
    {
        $this->validate(\compact('id'), [
            'id' => ['required', 'integer', 'min:1'],
        ]);

        $this->id = $id;

        return $this;
    }

    public function parentId(int $parent_id): self
    {
        $this->validate(\compact('parent_id'), [
            'parent_id' => ['required', 'integer', 'min:1'],
        ]);

        $this->parentId = $parent_id;

        return $this;
    }

    public function name(string $value): self
    {
        $this->validate(\compact('value'), [
            'value' => ['required', 'string'],
        ]);

        $this->name = \trim($value);

        return $this;
    }

    public function get(): DOMElement
    {
        $name       = 'category';
        $attributes = ['id' => $this->id];
        $value      = Str::e($this->name);

        return $this->xmlItem($name, $value, $attributes);
    }
}
