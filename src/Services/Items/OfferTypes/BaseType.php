<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes;

use DOMElement;
use Helldar\Yandex\GoodsPrices\Interfaces\Item;
use Helldar\Yandex\GoodsPrices\Traits\Items\BaseMethods;
use Helldar\Yandex\GoodsPrices\Traits\Items\BaseRules;
use Helldar\Yandex\GoodsPrices\Traits\Validator;
use Helldar\Yandex\GoodsPrices\Traits\Xml;

use function array_push;
use function compact;
use function in_array;
use function ksort;

abstract class BaseType implements Item
{
    use Xml;
    use Validator;
    use BaseMethods;
    use BaseRules;

    /** @var string|null */
    protected $type = 'vendor.model';

    private $required_items = [];

    private $items = [];

    public function get(): DOMElement
    {
        $offer = $this->offer();

        $this->validate($this->items, $this->rules(), $this->baseRules(), $this->required_items);

        return $this->make($offer);
    }

    protected function requiredItems(string ...$values)
    {
        foreach ($values as $value) {
            array_push($this->required_items, $value);
        }
    }

    protected function addItem($key, $value)
    {
        $this->items[$key] = $value;
    }

    protected function rules(): array
    {
        return [];
    }

    private function item($key)
    {
        return $this->items[$key] ?? null;
    }

    private function offer()
    {
        $id        = $this->item('id');
        $available = $this->item('available');
        $type      = $this->type;

        return $this->xmlItem('offer', null, compact('id', 'type', 'available'));
    }

    private function make(DOMElement $offer): DOMElement
    {
        ksort($this->items);

        foreach ($this->items as $key => $value) {
            if (in_array($key, ['id', 'type', 'available'])) {
                continue;
            }

            $item = $this->xmlItem($key, $value);

            $this->xmlAppendChild($offer, $item);
        }

        return $offer;
    }
}
