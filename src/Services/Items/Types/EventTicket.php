<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\Types;

use Helldar\Yandex\GoodsPrices\Helpers\Variables;
use Illuminate\Validation\Rule;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__event-ticket
 */
class EventTicket extends BaseType
{
    protected $type = 'artist.title';

    public function __construct()
    {
        parent::__construct();

        $this->requiredItems('delivery', 'name', 'place', 'date');
    }

    public function name(string $value): self
    {
        $this->addItem('name', $value);

        return $this;
    }

    public function place(string $value): self
    {
        $this->addItem('place', $value);

        return $this;
    }

    public function hallPlan(string $value): self
    {
        $this->addItem('hall plan', $value);

        return $this;
    }

    public function hallPart(string $value): self
    {
        $this->addItem('hall_part', $value);

        return $this;
    }

    public function date(string $value): self
    {
        $this->addItem('date', $value);

        return $this;
    }

    public function isPremiere(bool $value): self
    {
        $value = $value ? 'true' : 'false';

        $this->addItem('is_premiere', $value);

        return $this;
    }

    public function isKids(bool $value): self
    {
        $value = $value ? 'true' : 'false';

        $this->addItem('is_kids', $value);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'name'        => ['string', 'max:255'],
            'place'       => ['string', 'max:255'],
            'hall plan'   => ['url'],
            'hall_part'   => ['string', 'max:255'],
            'date'        => ['date_format:"Y-m-dTH:i"'],
            'is_premiere' => ['string', 'max:255', Rule::in(Variables::BOOLEAN)],
            'is_kids'     => ['string', 'max:255', Rule::in(Variables::BOOLEAN)],
        ];
    }
}
