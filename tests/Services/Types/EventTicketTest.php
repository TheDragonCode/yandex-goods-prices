<?php

namespace Tests\Services\Types;

use Carbon\Carbon;
use DOMDocument;
use Exception;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\EventTicket;
use Tests\TestCase;

class EventTicketTest extends TestCase
{
    public function testSuccess()
    {
        $actual = (new EventTicket)
            ->id(1234)
            ->available()
            ->categoryId(2)
            ->currencyId('USD')
            ->date(Carbon::now())
            ->delivery(true)
            ->hallPlan('http://example.com/image.jpg')
            ->isKids(false)
            ->isPremiere(true)
            ->name('foo')
            ->place('foo')
            ->price(200)
            ->url('http://example.com')
            ->get();

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<offer id="1234" type="event-ticket" available="true">
    <categoryId>2</categoryId>
    <currencyId>USD</currencyId>
    <date>2019-03-23T19:27+00:00</date>
    <delivery>true</delivery>
    <hall_plan>http://example.com/image.jpg</hall_plan>
    <is_kids>false</is_kids>
    <is_premiere>true</is_premiere>
    <name>foo</name>
    <place>foo</place>
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
            (new EventTicket)
                ->url('http://example.com')
                ->price(200)
                ->currencyId('USD')
                ->categoryId(2)
                ->name('foo')
                ->get();
        } catch (Exception $exception) {
            $this->assertEquals('The id field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }

    public function testFailedName()
    {
        try {
            (new EventTicket)
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
            $this->assertEquals('The name field is required.', $exception->getMessage());
            $this->assertEquals(400, $exception->getCode());
        }
    }
}
