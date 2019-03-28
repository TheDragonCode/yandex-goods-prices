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

    /**
     * @param array|\Helldar\Yandex\GoodsPrices\Services\Currency ...$items
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\YandexGoodsPrices
     */
    public function currencies(...$items): self
    {
        $this->each(Currency::class, $items, $this->currencies);

        return $this;
    }

    /**
     * @param array|\Helldar\Yandex\GoodsPrices\Services\Category ...$items
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\YandexGoodsPrices
     */
    public function categories(...$items): self
    {
        $this->each(Category::class, $items, $this->categories);

        return $this;
    }

    /**
     * @param array|\Helldar\Yandex\GoodsPrices\Services\Offer ...$items
     *
     * @return \Helldar\Yandex\GoodsPrices\Services\YandexGoodsPrices
     */
    public function offers(...$items): self
    {
        $this->each(Offer::class, $items, $this->offers);

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

    private function each($instance, $items, &$parent)
    {
        foreach ($items as $item) {
            if ($item instanceof $instance) {
                $this->xml->appendChild($parent, $item->get());
            } elseif (\is_array($item)) {
                foreach ($item as $element) {
                    $this->xml->appendChild($parent, $element->get());
                }
            }
        }
    }
}
