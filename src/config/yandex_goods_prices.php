<?php

return [
    /*
     * Storage name configuration to save files.
     *
     * Default, 'public'.
     */

    'storage' => env('YANDEX_GOODS_PRICES_STORAGE', 'public'),

    // Nicely formats output with indentation and extra space.

    'format_output' => env('YANDEX_GOODS_PRICES_FORMAT_OUTPUT', false),

    /*
     * The path to the file.
     *
     * Default, 'yandex-goods-prices.xml'.
     */

    'filename' => env('YANDEX_GOODS_PRICES_FILENAME', 'yandex-goods-prices.xml'),
];
