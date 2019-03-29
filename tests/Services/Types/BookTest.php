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
            ->author('bar')
            ->available()
            ->binding('foo')
            ->categoryId(2)
            ->currencyId('USD')
            ->delivery(true)
            ->description('foo')
            ->isbn('978-5-94878-004-7')
            ->language('rus')
            ->name('foo')
            ->pageExtent(4)
            ->part(2)
            ->price(200)
            ->publisher('foo')
            ->series('foo')
            ->tableOfContents('foo')
            ->url('http://example.com')
            ->volume(3)
            ->year(2019)
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="book" available="true">
    <ISBN>978-5-94878-004-7</ISBN>
    <author>bar</author>
    <binding>PDF</binding>
    <categoryId>2</categoryId>
    <currencyId>USD</currencyId>
    <delivery>false</delivery>
    <description>foo</description>
    <language>foo</language>
    <name>foo</name>
    <page_extent>200.30</page_extent>
    <part>3</part>
    <price>200</price>
    <publisher>foo</publisher>
    <series>foo</series>
    <table_of_contents>foo</table_of_contents>
    <url>http://example.com</url>
    <volume>4</volume>
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
                ->available()
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
