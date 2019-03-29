<?php

namespace Helldar\Yandex\GoodsPrices\Services\Items\Types;

/**
 * @see https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html#tag_11__audiobook
 */
class AudioBook extends BaseType
{
    protected $type = 'audiobook';

    public function __construct()
    {
        $this->requiredItems('delivery', 'name');
    }

    public function author(string $value): self
    {
        $this->addItem('author', $value);

        return $this;
    }

    public function name(string $value): self
    {
        $this->addItem('name', $value);

        return $this;
    }

    public function publisher(string $value): self
    {
        $this->addItem('publisher', $value);

        return $this;
    }

    public function series(string $value): self
    {
        $this->addItem('series', $value);

        return $this;
    }

    public function year(int $value): self
    {
        $this->addItem('year', $value);

        return $this;
    }

    public function isbn(string $value): self
    {
        $this->addItem('ISBN', $value);

        return $this;
    }

    public function description(string $value): self
    {
        $this->addItem('description', $value);

        return $this;
    }

    public function performedBy(string $value): self
    {
        $this->addItem('performed_by', $value);

        return $this;
    }

    public function performanceType(string $value): self
    {
        $this->addItem('performance_type', $value);

        return $this;
    }

    public function language(string $value): self
    {
        $this->addItem('language', $value);

        return $this;
    }

    public function volume(int $value): self
    {
        $this->addItem('volume', $value);

        return $this;
    }

    public function part(int $value): self
    {
        $this->addItem('part', $value);

        return $this;
    }

    public function format(string $value): self
    {
        $this->addItem('format', $value);

        return $this;
    }

    public function storage(string $value): self
    {
        $this->addItem('storage', $value);

        return $this;
    }

    public function recordingLength(string $value): self
    {
        $this->addItem('recording_length', $value);

        return $this;
    }

    public function tableOfContents(string $value): self
    {
        $this->addItem('table_of_contents', $value);

        return $this;
    }

    protected function rules(): array
    {
        return [
            'author'      => ['string', 'max:255'],
            'name'        => ['string', 'max:255'],
            'publisher'   => ['string', 'max:255'],
            'series'      => ['string', 'max:255'],
            'year'        => ['integer', 'max:' . \date('Y')],
            'ISBN'        => ['string'],
            'description' => ['string', 'max:175'],
            'volume'      => ['integer', 'min:0', 'gte:part'],
            'part'        => ['integer', 'min:0', 'required_id:volume'],
            'language'    => ['string', 'max:255'],
            'format'      => ['string', 'max:255'],
            'storage'     => ['string', 'max:255'],

            'recording_length'  => ['date_format:"i:s"'],
            'table_of_contents' => ['string'],
        ];
    }
}
