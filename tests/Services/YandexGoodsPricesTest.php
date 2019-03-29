<?php

namespace Tests\Services;

use Helldar\Yandex\GoodsPrices\Services\Category;
use Helldar\Yandex\GoodsPrices\Services\Currency;
use Helldar\Yandex\GoodsPrices\Services\Offer;
use Helldar\Yandex\GoodsPrices\Services\Service;
use Tests\TestCase;

class YandexGoodsPricesTest extends TestCase
{
    public function testName()
    {
        $item = (new Service)->name('foo');

        $this->assertTrue($item instanceof Service);
    }

    public function testCompany()
    {
        $item = (new Service)->company('bar');

        $this->assertTrue($item instanceof Service);
    }

    public function testUrl()
    {
        $item = (new Service)->url('http://example.com');

        $this->assertTrue($item instanceof Service);
    }

    public function testOffers()
    {
        $offer = (new Offer)
            ->id(1)
            ->name('foo')
            ->available(true)
            ->url('http://example.com')
            ->price(15.3)
            ->currencyId(3)
            ->categoryId(2)
            ->delivery(true);

        $item = (new Service)->offers($offer, $offer, $offer);

        $this->assertTrue($item instanceof Service);
    }

    public function testCurrencies()
    {
        $currency = (new Currency)->id('RUR')->rate(2);

        $item = (new Service)->currencies($currency, $currency, $currency);

        $this->assertTrue($item instanceof Service);
    }

    public function testCategories()
    {
        $category = (new Category)->id(1)->name('foo');

        $item = (new Service)->categories($category, $category, $category);

        $this->assertTrue($item instanceof Service);
    }

    public function testSave()
    {
        $filename = 'foo.xml';
        $path     = storage_path('app/public/' . $filename);

        $currency = (new Currency)->id('RUR')->rate(2);
        $category = (new Category)->id(1)->name('foo');

        $offer = (new Offer)
            ->id(1)
            ->name('foo')
            ->available(true)
            ->url('http://example.com')
            ->price(15.3)
            ->currencyId(3)
            ->categoryId(2)
            ->delivery(true);

        (new Service)
            ->categories($category, $category, $category)
            ->currencies($currency, $currency, $currency)
            ->offers($offer, $offer, $offer)
            ->name('foo')
            ->company('bar')
            ->url('http://example.com')
            ->save($filename);

        $this->assertFileExists($path);
    }

    public function testStructure()
    {
        $filename = 'foo.xml';
        $path     = storage_path('app/public/' . $filename);

        $currency = (new Currency)->id('RUR')->rate(2);
        $category = (new Category)->id(1)->name('foo');

        $offer = (new Offer)
            ->id(1)
            ->name('foo')
            ->available(true)
            ->url('http://example.com')
            ->price(15.3)
            ->currencyId(2)
            ->categoryId(1)
            ->delivery(true);

        (new Service)
            ->categories($category)
            ->currencies($currency)
            ->offers($offer)
            ->name('foo')
            ->company('bar')
            ->url('http://example.com')
            ->save($filename);

        $source = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="2018-10-19 12:00">
    <shop>
        <company>bar</company>
        <name>foo</name>
        <url>http://example.com</url>
        <categories>
            <category id="1">foo</category>
        </categories>
        <currencies>
            <currency id="RUR" rate="2"/>
        </currencies>
        <offers>
            <offer id="1" available="true">
                <categoryId>1</categoryId>
                <currencyId>RUR</currencyId>
                <delivery>true</delivery>
                <name>foo</name>
                <price>15.3</price>
                <url>http://example.com</url>
            </offer>
        </offers>
    </shop>
</yml_catalog>
XML;

        $expected = new \DOMDocument('1.0', 'utf-8');
        $expected->loadXML($source);

        $actual = new \DOMDocument('1.0', 'utf-8');
        $actual->load($path);

        $this->assertEqualXMLStructure($expected->documentElement, $actual->documentElement, true);
    }
}
