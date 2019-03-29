<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Video;
use Tests\TestCase;

class VideoTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new Video)
            ->id(1234)
            ->adult(true)
            ->available()
            ->categoryId(2)
            ->country('Россия')
            ->currencyId('RUB')
            ->delivery(false)
            ->director('foo')
            ->media('file')
            ->originalName('foo')
            ->price(200)
            ->starring(['foo', 'bar', 'baz'])
            ->title('foo')
            ->url('http://example.com')
            ->year(2019)
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="artist.title" available="true">
    <adult>true</adult>
    <categoryId>2</categoryId>
    <country>Россия</country>
    <currencyId>RUB</currencyId>
    <delivery>false</delivery>
    <director>foo</director>
    <media>file</media>
    <originalName>foo</originalName>
    <price>200</price>
    <starring>foo, bar, baz</starring>
    <title>foo</title>
    <url>http://example.com</url>
    <year>2019</year>
</offer>
XML;

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $this->assertEqualXMLStructure($expected->documentElement, $actual, true);
    }

    public function testFailed()
    {
        try {
            (new Video)
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

    public function testFailedTitle()
    {
        try {
            (new Video)
                ->id(1)
                ->available()
                ->delivery(false)
                ->url('http://example.com')
                ->price(200)
                ->currencyId('USD')
                ->categoryId(2)
                ->get();

            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertEquals('The title field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }

    public function testFailedCurrencyId()
    {
        try {
            (new Video)
                ->id(1)
                ->available()
                ->categoryId(2)
                ->currencyId('QWE')
                ->delivery(false)
                ->price(200)
                ->title('foo')
                ->url('http://example.com')
                ->get();

            $this->assertTrue(false);
        } catch (Exception $exception) {
            $this->assertEquals('The selected currency id is invalid.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }
}
