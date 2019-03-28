<?php

namespace Tests\Services;

use DOMDocument;
use DOMElement;
use Helldar\Yandex\GoodsPrices\Services\Offer;
use Tests\TestCase;

class OfferTest extends TestCase
{
    public function testPrice()
    {
        $item = (new Offer)->id(2);

        $this->assertTrue($item instanceof Offer);
    }

    public function testAvailable()
    {
        $item = (new Offer)->available(false);

        $this->assertTrue($item instanceof Offer);
    }

    public function testDelivery()
    {
        $item = (new Offer)->delivery(true);

        $this->assertTrue($item instanceof Offer);
    }

    public function testCategoryId()
    {
        $item = (new Offer)->categoryId(3);

        $this->assertTrue($item instanceof Offer);
    }

    public function testName()
    {
        $item = (new Offer)->name('foo');

        $this->assertTrue($item instanceof Offer);
    }

    public function testCurrencyId()
    {
        $item = (new Offer)->currencyId(3);

        $this->assertTrue($item instanceof Offer);
    }

    public function testId()
    {
        $item = (new Offer)->id(2);

        $this->assertTrue($item instanceof Offer);
    }

    public function testUrl()
    {
        $item = (new Offer)->url('http://example.com');

        $this->assertTrue($item instanceof Offer);
    }

    public function testGet()
    {
        $item = (new Offer)
            ->id(1)
            ->name('foo')
            ->available(true)
            ->url('http://example.com')
            ->price(15.3)
            ->currencyId(3)
            ->categoryId(2)
            ->delivery(true)
            ->get();

        $doc   = new DOMDocument('1.0', 'utf-8');
        $offer = $doc->createElement('offer');

        $offer->setAttribute('id', 1);
        $offer->setAttribute('available', 'true');

        $url   = $doc->createElement('url', 'http://example.com');
        $price = $doc->createElement('price', 15.3);
        $name  = $doc->createElement('name', 'foo');

        $currency_id = $doc->createElement('currencyId', 3);
        $category_id = $doc->createElement('categoryId', 2);

        $delivery = $doc->createElement('delivery', 'true');

        $offer->appendChild($category_id);
        $offer->appendChild($currency_id);
        $offer->appendChild($delivery);
        $offer->appendChild($name);
        $offer->appendChild($price);
        $offer->appendChild($url);

        $this->assertTrue($item instanceof DOMElement);

        $this->assertEqualXMLStructure($offer, $item, true);
    }
}
