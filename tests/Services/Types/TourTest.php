<?php

namespace Tests\Services\Types;

use Carbon\Carbon;
use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Tour;
use Tests\TestCase;

class TourTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new Tour)
            ->id(1234)
            ->available()
            ->categoryId(2)
            ->country('Россия')
            ->currencyId('RUB')
            ->dataTour(Carbon::parse('2019-03-29T00:00+00:00'))
            ->days(3)
            ->delivery(true)
            ->description('foo')
            ->hotelStars(3)
            ->included('foo')
            ->meal('HB')
            ->name('foo')
            ->price(200)
            ->region('baz')
            ->room('SNG')
            ->transport('bar')
            ->url('http://example.com')
            ->worldRegion('foo')
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="tour" available="true">
    <categoryId>2</categoryId>
    <country>Россия</country>
    <currencyId>RUB</currencyId>
    <dataTour>2019-03-29T00:00+00:00</dataTour>
    <days>3</days>
    <delivery>true</delivery>
    <description>foo</description>
    <hotel_stars>3</hotel_stars>
    <included>foo</included>
    <meal>HB</meal>
    <name>foo</name>
    <price>200</price>
    <region>baz</region>
    <room>SNG</room>
    <transport>bar</transport>
    <url>http://example.com</url>
    <worldRegion>foo</worldRegion>
</offer>
XML;

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $this->assertEqualXMLStructure($expected->documentElement, $actual, true);
    }

    public function testFailed()
    {
        try {
            (new Tour)
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

    public function testFailedDays()
    {
        try {
            (new Tour)
                ->id(1)
                ->available()
                ->categoryId(2)
                ->currencyId('USD')
                ->delivery(false)
                ->price(200)
                ->url('http://example.com')
                ->get();

            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertEquals('The days field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }

    public function testFailedCurrencyId()
    {
        try {
            (new Tour)
                ->id(1)
                ->available()
                ->categoryId(2)
                ->currencyId('QWE')
                ->days(3)
                ->delivery(false)
                ->included('foo')
                ->name('foo')
                ->price(200)
                ->transport('bar')
                ->url('http://example.com')
                ->get();

            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertEquals('The selected currency id is invalid.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }
}
