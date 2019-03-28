<?php

namespace Tests\Services;

use DOMDocument;
use DOMElement;
use Helldar\Yandex\GoodsPrices\Services\Currency;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function testGet()
    {
        $item = (new Currency)
            ->id('USD')
            ->rate(3)
            ->get();

        $doc      = new DOMDocument('1.0', 'utf-8');
        $expected = $doc->createElement('currency');

        $expected->setAttribute('id', 'USD');
        $expected->setAttribute('rate', 3);

        $this->assertTrue($item instanceof DOMElement);

        $this->assertEqualXMLStructure($expected, $item, true);
    }

    public function testId()
    {
        $item = (new Currency)->id('RUR');

        $this->assertTrue($item instanceof Currency);
    }

    public function testName()
    {
        $item = (new Currency)->rate(3);

        $this->assertTrue($item instanceof Currency);
    }
}
