<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use Helldar\Core\Xml\Facades\Xml;
use Helldar\Core\Xml\Helpers\Str;
use Helldar\Yandex\GoodsPrices\Services\Items\Category;
use Helldar\Yandex\GoodsPrices\Services\Items\Currency;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\AudioBook;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Book;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\EventTicket;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Music;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Other;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Tour;
use Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes\Video;
use Helldar\Yandex\GoodsPrices\Traits\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Service
{
    use Validator;

    /** @var \Helldar\Core\Xml\Facades\Xml */
    protected $xml;

    /** @var \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Support\Facades\Storage */
    protected $storage;

    /** @var \DOMElement */
    private $name;

    /** @var \DOMElement */
    private $company;

    /** @var \DOMElement */
    private $url;

    /** @var \DOMElement */
    private $currencies;

    /** @var \DOMElement */
    private $categories;

    /** @var \DOMElement */
    private $offers;

    public function __construct()
    {
        $this->initXml();

        $disk          = Config::get('yandex_goods_prices.storage', 'public');
        $this->storage = Storage::disk($disk);
    }

    public function name(string $value): self
    {
        $value = Str::e(\trim($value));

        $this->validate(\compact('value'), [
            'value' => 'required|string|max:20',
        ]);

        $this->name = $this->xml->makeItem('name', $value);

        return $this;
    }

    public function company(string $value): self
    {
        $value = Str::e(\trim($value));

        $this->validate(\compact('value'), [
            'value' => 'required|string|max:255',
        ]);

        $this->company = $this->xml->makeItem('company', $value);

        return $this;
    }

    public function url(string $url): self
    {
        $value = Str::e(\trim($url));

        $this->validate(\compact('value'), [
            'value' => 'required|url',
        ]);

        $this->url = $this->xml->makeItem('url', $value);

        return $this;
    }

    /**
     * @param array|\Helldar\Yandex\GoodsPrices\Services\Items\Currency ...$items
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\Service
     */
    public function currencies(...$items): self
    {
        $this->each($this->currencies, Currency::class, $items);

        return $this;
    }

    /**
     * @param array|\Helldar\Yandex\GoodsPrices\Services\Items\Category ...$items
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\Service
     */
    public function categories(...$items): self
    {
        $this->each($this->categories, Category::class, $items);

        return $this;
    }

    /**
     * @param array|\Helldar\Yandex\GoodsPrices\Services\Items\Offer ...$items
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\Service
     */
    public function offers(...$items): self
    {
        $instances = [
            AudioBook::class,
            Book::class,
            EventTicket::class,
            Music::class,
            Other::class,
            Tour::class,
            Video::class,
        ];

        $this->each($this->offers, $instances, $items);

        return $this;
    }

    public function save(string $filename = null): bool
    {
        $path = $filename ?: Config::get('yandex_goods_prices.filename');

        $shop = $this->xml->makeItem('shop');

        $this->xml->appendChild($shop, $this->company);
        $this->xml->appendChild($shop, $this->name);
        $this->xml->appendChild($shop, $this->url);
        $this->xml->appendChild($shop, $this->categories);
        $this->xml->appendChild($shop, $this->currencies);
        $this->xml->appendChild($shop, $this->offers);

        $this->xml->appendToRoot($shop);

        return $this->storage->put($path, $this->xml->get());
    }

    private function initXml()
    {
        $root          = 'yml_catalog';
        $attributes    = ['date' => \date('Y-m-d H:i')];
        $format_output = Config::get('yandex_goods_prices.format_output', false);

        $this->xml = Xml::init($root, $attributes, $format_output)
            ->doctype('yml_catalog', null, 'shops.dtd');

        $this->categories = $this->xml->makeItem('categories');
        $this->currencies = $this->xml->makeItem('currencies');
        $this->offers     = $this->xml->makeItem('offers');
    }

    private function each(&$parent, $instance, $items, $recurse = true)
    {
        \array_map(function ($item) use (&$parent, $instance, $recurse) {
            $is_instance = $this->checkOfferInstance($instance, $item);

            if ($is_instance) {
                $this->xml->appendChild($parent, $item->get());

                return;
            }

            if ($recurse && \is_array($item)) {
                $this->each($parent, $instance, $item, false);
            }
        }, $items);
    }

    /**
     * @param array|object $expected
     * @param object $actual
     *
     * @return bool
     */
    private function checkOfferInstance($expected, $actual): bool
    {
        if (\is_array($expected)) {
            foreach ($expected as $instance) {
                if ($this->checkOfferInstance($instance, $actual)) {
                    return true;
                }
            }

            return false;
        }

        return $actual instanceof $expected;
    }
}
