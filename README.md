# Yandex Goods Prices

![yandex-goods-prices](https://user-images.githubusercontent.com/10347617/55163142-4bbc4380-517a-11e9-8777-03d3775507bb.png)

<p align="center">
    <a href="https://styleci.io/repos/178002083"><img src="https://styleci.io/repos/178002083/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/yandex-goods-prices"><img src="https://img.shields.io/packagist/dt/andrey-helldar/yandex-goods-prices.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/yandex-goods-prices"><img src="https://poser.pugx.org/andrey-helldar/yandex-goods-prices/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/yandex-goods-prices"><img src="https://poser.pugx.org/andrey-helldar/yandex-goods-prices/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/yandex-goods-prices/license?format=flat-square" alt="License" /></a>
</p>


## Content

* [Installation](#installation)
* [Using](#using)
* [License](#license)


## Installation

To get the latest version of Laravel Yandex Goods Prives package, simply require the project using [Composer](https://getcomposer.org):

```
composer require andrey-helldar/yandex-goods-prices
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/yandex-goods-prices": "^1.0"
    }
}
```

If you don't use auto-discovery, add the `ServiceProvider` to the providers array in `config/app.php`:

```php
Helldar\Yandex\GoodsPrices\ServiceProvider::class,
```

You can also publish the config file to change implementations (ie. interface to specific class):

```
php artisan vendor:publish --provider="Helldar\Yandex\GoodsPrices\ServiceProvider"
```


## Using

```php
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
    ->save();
```

Saved as:
```xml
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
```

You can also use an array for a `categories()`, `currencies()` and `offers` methods:
```php
$currencies = [];

for ($i = 0; $i < 10; $i++) {
    $currency = \app('yandex_goods_prices')->currency()->id('USD')->rate($i);
    
    array_push($currencies, $currency);
}

\app('yandex_goods_prices')->service()
    ->categories($category_1, $category_2, $categories)
    ->currencies($currency_rur, $currencies)
    ->offers($offers, $offer_1, $offer_2)
    // ...
```


## License

This package is released under the [MIT License](LICENSE).
