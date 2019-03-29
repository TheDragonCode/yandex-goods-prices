<?php

namespace Tests\Services;

use DOMDocument;
use DOMElement;
use Helldar\Yandex\GoodsPrices\Services\Items\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testGet()
    {
        $item = (new Category)
            ->id(1)
            ->name('foo')
            ->get();

        $doc      = new DOMDocument('1.0', 'utf-8');
        $expected = $doc->createElement('category');
        $text     = $doc->createTextNode('foo');

        $expected->setAttribute('id', 1);
        $expected->appendChild($text);

        $this->assertTrue($item instanceof DOMElement);

        $this->assertEqualXMLStructure($expected, $item, true);
    }

    public function testId()
    {
        $item = (new Category)->id(1);

        $this->assertTrue($item instanceof Category);
    }

    public function testName()
    {
        $item = (new Category)->name('foo');

        $this->assertTrue($item instanceof Category);
    }
}
