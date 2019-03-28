<?php

namespace Helldar\Yandex\GoodsPrices\Services;

use Helldar\Core\Xml\Facades\Xml;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class YandexGoodsPrices
{
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
        $this->name = $this->xml->makeItem('name', \trim($value));

        return $this;
    }

    public function company(string $value): self
    {
        $this->company = $this->xml->makeItem('company', \trim($value));

        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $this->xml->makeItem('url', \trim($url));

        return $this;
    }

    public function currencies(Currency ...$currencies): self
    {
        foreach ($currencies as $currency) {
            $this->xml->appendChild($this->currencies, $currency->get());
        }

        return $this;
    }

    public function categories(Category ...$categories): self
    {
        foreach ($categories as $category) {
            $this->xml->appendChild($this->categories, $category->get());
        }

        return $this;
    }

    public function offers(Offer ...$offers): self
    {
        foreach ($offers as $offer) {
            $this->xml->appendChild($this->offers, $offer->get());
        }

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
        $format_output = Config::get('yandex_goods_prices.format_output', true);

        $this->xml = Xml::init($root, $attributes, $format_output)
            ->doctype('yml_catalog', null, 'shops.dtd');

        $this->categories = $this->xml->makeItem('categories');
        $this->currencies = $this->xml->makeItem('currencies');
        $this->offers     = $this->xml->makeItem('offers');
    }
}
