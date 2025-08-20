<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Music;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class CatalogueNumber implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([A-Z])([A-Z0-9 ]{2,})$/';
    public const int CanonicalMaxLength = 32;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'XCD023';

    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtoupper($value);
        $value = (string)preg_replace('/[^A-Z0-9]/', '', $value);
        $value = (string)preg_replace('/([A-Z])([0]+)([1-9]+)/', '$1$3', $value);

        return $value;
    }

    protected function prepareNormalized(
        string $value
    ): string {
        return strtoupper(trim($this->raw));
    }

    protected function prepareHtml(
        string $value
    ): Markup {
        return Element::create('samp.number.music.catalogue', function () use ($value) {
            yield Element::create('span.value', $this->prepareNormalized($value));
        }, [
            'title' => $this->canonical
        ]);
    }
}
