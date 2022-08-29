<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Other;
use Tests\TestCase;

class OtherTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new Other())
            ->id(1234)
            ->available()
            ->categoryId(2)
            ->countryOfOrigin('Россия')
            ->currencyId('USD')
            ->delivery(true)
            ->deliveryOptions(200)
            ->description('foo')
            ->downloadable(true)
            ->manufacturerWarranty('foo')
            ->model('bar')
            ->price(200)
            ->salesNotes('foo')
            ->typePrefix('foo')
            ->url('http://example.com')
            ->vendor('FOO')
            ->vendorCode('foo')
            ->get();

        $source = <<<'XML'
            <?xml version="1.0" encoding="UTF-8"?>
            <offer id="1234" type="audiobook" available="true">
                <categoryId>2</categoryId>
                <country_of_origin>Россия</country_of_origin>
                <currencyId>2</currencyId>
                <delivery>true</delivery>
                <delivery-options>200</delivery-options>
                <description>foo</description>
                <downloadable>true</downloadable>
                <manufacturer_warranty>foo</manufacturer_warranty>
                <model>bar</model>
                <price>200</price>
                <sales_notes>foo</sales_notes>
                <typePrefix>foo</typePrefix>
                <url>http://example.com</url>
                <vendor>FOO</vendor>
                <vendorCode>foo</vendorCode>
            </offer>
            XML;

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $this->assertEqualXMLStructure($expected->documentElement, $actual, true);
    }

    public function testFailed()
    {
        try {
            (new Other())
                ->url('http://example.com')
                ->price(200)
                ->currencyId('USD')
                ->categoryId(2)
                ->get();
        }
        catch (Exception $exception) {
            $this->assertEquals('The id field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }
}
