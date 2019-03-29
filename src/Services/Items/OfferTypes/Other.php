<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\OfferTypes;

use Helldar\Yandex\GoodsPrices\Helpers\Variables;
use Illuminate\Validation\Rule;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__vendor-model
 */
class Other extends BaseType
{
    public function __construct()
    {
        $this->requiredItems('delivery', 'vendor', 'model');
    }

    public function typePrefix(string $value): self
    {
        $this->addItem('typePrefix', $value);

        return $this;
    }

    public function vendor(string $value): self
    {
        $this->addItem('vendor', $value);

        return $this;
    }

    public function model(string $value): self
    {
        $this->addItem('model', $value);

        return $this;
    }

    public function description(string $value): self
    {
        $this->addItem('description', $value);

        return $this;
    }

    public function vendorCode(string $value): self
    {
        $this->addItem('vendorCode', $value);

        return $this;
    }

    public function deliveryOptions(int $value): self
    {
        $this->addItem('delivery-options', $value);

        return $this;
    }

    public function salesNotes(string $value): self
    {
        $this->addItem('sales_notes', $value);

        return $this;
    }

    public function manufacturerWarranty(string $value): self
    {
        $this->addItem('manufacturer_warranty', $value);

        return $this;
    }

    public function countryOfOrigin(string $value): self
    {
        $this->addItem('country_of_origin', $value);

        return $this;
    }

    public function downloadable(bool $value): self
    {
        $value = $value ? 'true' : 'false';

        $this->addItem('downloadable', $value);

        return $this;
    }

    public function adult(string $value): self
    {
        $this->addItem('adult', $value);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'description' => ['string', 'max:175'],
            'model'       => ['string', 'max:255'],
            'sales_notes' => ['string', 'max:50'],
            'typePrefix'  => ['string', 'max:512'],
            'vendor'      => ['string', 'max:255'],
            'vendorCode'  => ['string', 'max:255'],

            'delivery-options' => ['integer', 'min:0'],

            'manufacturer_warranty' => ['string', 'max:255'],
            'country_of_origin'     => ['string', Rule::in(Variables::COUNTRIES)],

            'downloadable' => ['string', 'max:255', Rule::in(Variables::BOOLEAN)],
            'adult'        => ['string', 'max:255', Rule::in(Variables::BOOLEAN)],
        ];
    }
}
