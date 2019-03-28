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
use Helldar\Yandex\GoodsPrices\Services\Category;
use Helldar\Yandex\GoodsPrices\Services\Currency;
use Helldar\Yandex\GoodsPrices\Services\Offer;
use Helldar\Yandex\GoodsPrices\Services\YandexGoodsPrices;

$currency_rur = (new Currency)->id('RUR')->rate(1);
$currency_eur = (new Currency)->id('USD')->rate(2);

$category_1 = (new Category)->id(1)->name('foo');
$category_2 = (new Category)->id(2)->name('bar');

$offer_1 = (new Offer)
    ->id(1)
    ->name('foo')
    ->available(true)
    ->url('http://example.com/item/1')
    ->price(15.3)
    ->currencyId(1)
    ->categoryId(2)
    ->delivery(true);

$offer_2 = (new Offer)
    ->id(2)
    ->name('bar')
    ->available(true)
    ->url('http://example.com/item/2')
    ->price(700)
    ->currencyId(2)
    ->categoryId(1)
    ->delivery(false);

(new YandexGoodsPrices)
    ->categories($category_1, $category_2)
    ->currencies($currency_rur, $currency_eur)
    ->offers($offer_1, $offer_2)
    ->name('shop name')
    ->company('company name')
    ->url('http://example.com')
    ->save();
```

Saved as:
```xml
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="2019-03-28 13:50">
  <shop>
    <company>company name</company>
    <name>shop name</name>
    <url>http://example.com</url>
    <categories>
      <category id="1">foo</category>
      <category id="2">bar</category>
    </categories>
    <currencies>
      <currency id="RUR" rate="1"/>
      <currency id="USD" rate="2"/>
    </currencies>
    <offers>
      <offer id="1" available="1">
        <categoryId>2</categoryId>
        <currencyId>1</currencyId>
        <delivery>true</delivery>
        <name>foo</name>
        <price>15.3</price>
        <url>http://example.com/item/1</url>
      </offer>
      <offer id="2" available="1">
        <categoryId>1</categoryId>
        <currencyId>2</currencyId>
        <delivery>false</delivery>
        <name>bar</name>
        <price>700</price>
        <url>http://example.com/item/2</url>
      </offer>
    </offers>
  </shop>
</yml_catalog>
```

You can also use an array for a `categories()`, `currencies()` and `offers` methods:
```php
$currencies = [];

for ($i = 0; $i < 10; $i++) {
    $currency = (new Currency)->id('USD')->rate($i);
    
    array_push($currencies, $currency);
}

(new YandexGoodsPrices)
    ->categories($category_1, $category_2, $categories)
    ->currencies($currency_rur, $currencies)
    ->offers($offers, $offer_1, $offer_2)
    // ...
```


## License

This package is released under the [MIT License](LICENSE).
