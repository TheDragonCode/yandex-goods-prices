<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\Types;

use DOMDocument;
use Exception;
use Tests\TestCase;

class AudioBookTest extends TestCase
{
    public function testFormat()
    {
        $item = (new AudioBook)->format('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testYear()
    {
        $item = (new AudioBook)->year(2019);

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testTableOfContents()
    {
        $item = (new AudioBook)->tableOfContents('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testPublisher()
    {
        $item = (new AudioBook)->publisher('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testPart()
    {
        $item = (new AudioBook)->part(4);

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testDescription()
    {
        $item = (new AudioBook)->description('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testVolume()
    {
        $item = (new AudioBook)->volume(4);

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testIsbn()
    {
        $item = (new AudioBook)->isbn('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testPerformanceType()
    {
        $item = (new AudioBook)->performanceType('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testRecordingLength()
    {
        $item = (new AudioBook)->recordingLength('02:03');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testName()
    {
        $item = (new AudioBook)->name('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testSeries()
    {
        $item = (new AudioBook)->series('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testPerformedBy()
    {
        $item = (new AudioBook)->performedBy('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testStorage()
    {
        $item = (new AudioBook)->storage('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testAuthor()
    {
        $item = (new AudioBook)->author('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testLanguage()
    {
        $item = (new AudioBook)->language('foo');

        $this->assertTrue($item instanceof AudioBook);
    }

    public function testSuccessFillabled()
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
            ->year(2019)
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
    <year>2019</year>
</offer>
XML;

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $this->assertEqualXMLStructure($expected->documentElement, $actual, true);
    }

    public function testFailFillabled()
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
