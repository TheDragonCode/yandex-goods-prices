<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\WithoutType;
use Tests\TestCase;

class WithoutTypeTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new WithoutType())
            ->id(1234)
            ->available()
            ->categoryId(2)
            ->currencyId('USD')
            ->delivery(true)
            ->url('http://example.com')
            ->name('Foo Bar')
            ->price(200)
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" available="true">
    <categoryId>2</categoryId>
    <currencyId>2</currencyId>
    <delivery>true</delivery>
    <name>Foo Bar</name>
    <price>200</price>
    <url>http://example.com</url>
</offer>
XML;

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $this->assertEqualXMLStructure($expected->documentElement, $actual, true);
    }

    public function testFailed()
    {
        try {
            (new WithoutType())
                ->url('http://example.com')
                ->price(200)
                ->currencyId('USD')
                ->categoryId(2)
                ->get();
        } catch (Exception $exception) {
            $this->assertEquals('The id field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }
}
