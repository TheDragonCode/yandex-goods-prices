<?php

namespace Helldar\Yandex\GoodsPrices;

use Helldar\Yandex\GoodsPrices\Facades\YandexGoodsPrices;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/yandex_goods_prices.php' => config_path('yandex_goods_prices.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/yandex_goods_prices.php', 'yandex_goods_prices');

        $this->app->singleton('yandex_goods_prices', YandexGoodsPrices::class);
    }

    public function provides()
    {
        return ['yandex_goods_prices'];
    }
}
