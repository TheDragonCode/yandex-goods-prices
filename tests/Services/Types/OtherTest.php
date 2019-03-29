<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\AudioBook;
use Tests\TestCase;

class OtherTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new AudioBook)
            ->id(1234)
            ->available(true)
            ->url('http://example.com')
            ->price(200)
            ->currencyId('USD')
            ->categoryId(2)
            ->name('foo')
            ->author('bar')
            ->publisher('foo')
            ->series('foo')
            ->year(2019)
            ->isbn('978-5-94878-004-7')
            ->description('foo')
            ->performedBy('foo')
            ->performanceType('foo')
            ->language('foo')
            ->volume(4)
            ->part(3)
            ->format('DVD')
            ->storage('PDF')
            ->recordingLength('200.30')
            ->tableOfContents('foo')
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="audiobook" available="true">
    <url>http://example.com</url>
    <price>200</price>
    <currencyId>USD</currencyId>
    <categoryId>2</categoryId>
    <name>foo</name>
    <author>bar</author>
    <publisher>foo</publisher>
    <series>foo</series>
    <year>2019</year>
    <ISBN>978-5-94878-004-7</ISBN>
    <description>foo</description>
    <performed_by>foo</performed_by>
    <performance_type>foo</performance_type>
    <language>foo</language>
    <volume>4</volume>
    <part>3</part>
    <format>DVD</format>
    <storage>PDF</storage>
    <recording_length>200.30</recording_length>
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
            (new AudioBook)
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
}
