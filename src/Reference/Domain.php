<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class Domain implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([^@\s\.]+\.[^@\s]{2,})$/';
    public const int CanonicalMaxLength = 2048;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'example.com';

    protected function prepareCanonicalString(
        string $value
    ): string {
        return strtolower($value);
    }

    protected function prepareNormalized(
        string $value
    ): string {
        return trim($value);
    }

    protected function prepareHtml(
        string $value
    ): Markup {
        return Element::create('a.domain', $this->prepareNormalized($value), [
            'href' => 'https://' . $value,
            'title' => $this->canonical
        ]);
    }
}
