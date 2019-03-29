<?php

namespace Tests;

use Helldar\Yandex\GoodsPrices\Services\Items\Category;
use Helldar\Yandex\GoodsPrices\Services\Items\Currency;
use Helldar\Yandex\GoodsPrices\Services\Items\Offer;
use Helldar\Yandex\GoodsPrices\Services\Service;

class AppTest extends TestCase
{
    public function testFacade()
    {
        $service  = \app('yandex_goods_prices')->service();
        $category = \app('yandex_goods_prices')->category();
        $currency = \app('yandex_goods_prices')->currency();
        $offer    = \app('yandex_goods_prices')->offer();

        $this->assertTrue($service instanceof Service);
        $this->assertTrue($category instanceof Category);
        $this->assertTrue($currency instanceof Currency);
        $this->assertTrue($offer instanceof Offer);
    }

    public function testSave()
    {
        $filename = 'foo.xml';
        $path     = \storage_path('app/public/' . $filename);

        $currency = \app('yandex_goods_prices')->currency()->id('RUB')->rate(2);
        $category = \app('yandex_goods_prices')->category()->id(1)->name('foo');

        $offer = \app('yandex_goods_prices')->offer()->other()
            ->id(1234)
            ->available()
            ->categoryId(2)
            ->countryOfOrigin('Россия')
            ->currencyId('USD')
            ->delivery(true)
            ->deliveryOptions(200)
            ->description('foo')
            ->downloadable(true)
            ->manufacturerWarranty('foo')
            ->model('bar')
            ->price(200)
            ->salesNotes('foo')
            ->typePrefix('foo')
            ->url('http://example.com')
            ->vendor('FOO')
            ->vendorCode('foo');

        \app('yandex_goods_prices')->service()
            ->categories($category, $category, $category)
            ->currencies($currency, $currency, [$currency, $currency, $currency])
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
        $path     = \storage_path('app/public/' . $filename);

        $currency = \app('yandex_goods_prices')->currency()->id('RUB')->rate(2);
        $category = \app('yandex_goods_prices')->category()->id(1)->name('foo');

        $offer = \app('yandex_goods_prices')->offer()->other()
            ->id(1234)
            ->available()
            ->categoryId(2)
            ->countryOfOrigin('Россия')
            ->currencyId('USD')
            ->delivery(true)
            ->deliveryOptions(200)
            ->description('foo')
            ->downloadable(true)
            ->manufacturerWarranty('foo')
            ->model('bar')
            ->price(200)
            ->salesNotes('foo')
            ->typePrefix('foo')
            ->url('http://example.com')
            ->vendor('FOO')
            ->vendorCode('foo');

        \app('yandex_goods_prices')->service()
            ->categories($category, $category)
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
            <category id="1">foo</category>
        </categories>
        <currencies>
            <currency id="RUB" rate="2"/>
        </currencies>
        <offers>
            <offer id="1234" type="audiobook" available="true">
                <categoryId>2</categoryId>
                <country_of_origin>Россия</country_of_origin>
                <currencyId>2</currencyId>
                <delivery>true</delivery>
                <delivery-options>200</delivery-options>
                <description>foo</description>
                <downloadable>true</downloadable>
                <manufacturer_warranty>foo</manufacturer_warranty>
                <model>bar</model>
                <price>200</price>
                <sales_notes>foo</sales_notes>
                <typePrefix>foo</typePrefix>
                <url>http://example.com</url>
                <vendor>FOO</vendor>
                <vendorCode>foo</vendorCode>
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
