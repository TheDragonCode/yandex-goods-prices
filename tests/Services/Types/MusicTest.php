<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Music;
use Tests\TestCase;

class MusicTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new Music)
            ->id(1234)
            ->artist('foo')
            ->available()
            ->categoryId(2)
            ->currencyId('USD')
            ->delivery(true)
            ->media('file')
            ->price(200)
            ->title('bar')
            ->url('http://example.com')
            ->year(2019)
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="artist.title" available="true">
    <artist>foo</artist>
    <categoryId>2</categoryId>
    <currencyId>USD</currencyId>
    <delivery>true</delivery>
    <media>file</media>
    <price>200</price>
    <title>bar</title>
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
            (new Music)
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
            (new Music)
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
            (new Music)
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
