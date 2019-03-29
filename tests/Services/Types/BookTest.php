<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\Book;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new Book)
            ->id(1234)
            ->available(true)
            ->url('http://example.com')
            ->price(200)
            ->currencyId('USD')
            ->categoryId(2)
            ->delivery(true)
            ->author('bar')
            ->name('foo')
            ->publisher('foo')
            ->series('foo')
            ->year(2019)
            ->isbn('978-5-94878-004-7')
            ->description('foo')
            ->volume(3)
            ->part(2)
            ->language('rus')
            ->binding('foo')
            ->pageExtent(4)
            ->tableOfContents('foo')
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="audiobook" available="true">
    <url>http://example.com</url>
    <price>200</price>
    <currencyId>USD</currencyId>
    <categoryId>2</categoryId>
    <author>bar</author>
    <name>foo</name>
    <publisher>foo</publisher>
    <series>foo</series>
    <year>2019</year>
    <ISBN>978-5-94878-004-7</ISBN>
    <description>foo</description>
    <volume>4</volume>
    <part>3</part>
    <language>foo</language>
    <binding>PDF</binding>
    <page_extent>200.30</page_extent>
    <table_of_contents>foo</table_of_contents>
</offer>
XML;

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $this->assertEqualXMLStructure($expected->documentElement, $actual, true);
    }

    public function testFailed()
    {
        try {
            (new Book)
                ->url('http://example.com')
                ->price(200)
                ->currencyId('USD')
                ->categoryId(2)
                ->name('foo')
                ->author('bar')
                ->year(2019)
                ->get();
        } catch (Exception $exception) {
            $this->assertEquals('The id field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }

    public function testFailedName()
    {
        try {
            (new Book)
                ->id(1)
                ->available(true)
                ->url('http://example.com')
                ->price(200)
                ->currencyId('USD')
                ->categoryId(2)
                ->delivery(false)
                ->author('bar')
                ->year(2019)
                ->get();

            $this->assertFalse(true);
        } catch (Exception $exception) {
            $this->assertEquals('The name field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }
}
