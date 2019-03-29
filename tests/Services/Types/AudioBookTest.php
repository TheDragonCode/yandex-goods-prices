<?php

namespace Tests\Services\Types;

use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\Types\AudioBook;
use Tests\TestCase;

class AudioBookTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new AudioBook)
            ->id(1234)
            ->author('bar')
            ->available()
            ->categoryId(2)
            ->currencyId('USD')
            ->delivery(false)
            ->description('foo')
            ->format('DVD')
            ->isbn('978-5-94878-004-7')
            ->language('foo')
            ->name('foo')
            ->part(3)
            ->performanceType('foo')
            ->performedBy('foo')
            ->price(200)
            ->publisher('foo')
            ->recordingLength('200.30')
            ->series('foo')
            ->storage('PDF')
            ->tableOfContents('foo')
            ->url('http://example.com')
            ->volume(4)
            ->year(2019)
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="audiobook" available="true">
    <ISBN>978-5-94878-004-7</ISBN>
    <author>bar</author>
    <categoryId>2</categoryId>
    <currencyId>USD</currencyId>
    <delivery>false</delivery>
    <description>foo</description>
    <format>DVD</format>
    <language>foo</language>
    <name>foo</name>
    <part>3</part>
    <performance_type>foo</performance_type>
    <performed_by>foo</performed_by>
    <price>200</price>
    <publisher>foo</publisher>
    <recording_length>200.30</recording_length>
    <series>foo</series>
    <storage>PDF</storage>
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
