<?php

namespace Helldar\Yandex\GoodsPrices\Traits;

use DOMElement;
use Helldar\Core\Xml\Facades\Xml as XmlFacade;

trait Xml
{
    /** @var \Helldar\Core\Xml\Facades\Xml */
    protected $doc;

    private function xmlItem(string $name, $value = null, array $attributes = []): DOMElement
    {
        if (is_null($this->doc)) {
            $this->doc = XmlFacade::init();
        }

        return $this->doc->makeItem($name, $value, $attributes);
    }
}
