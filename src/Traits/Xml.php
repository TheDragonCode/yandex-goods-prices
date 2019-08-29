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
            $this->doc = XmlFacade::init()
                ->setSkipEmptyAttributes();
        }

        return $this->doc->makeItem($name, $value, $attributes);
    }

    private function xmlAppendChild(DOMElement &$parent, DOMElement $child, bool $skip_empty = true)
    {
        if ($skip_empty && !$child) {
            return;
        }

        $parent->appendChild($child);
    }
}
