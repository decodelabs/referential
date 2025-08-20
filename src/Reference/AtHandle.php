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

class AtHandle implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^@([^@\s]+)$/';
    public const int CanonicalMaxLength = 256;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = '@username';

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
        return Element::create('span.handle', [
            Element::create('span.grammar', '@'),
            $this->prepareNormalized($value)
        ], [
            'title' => $this->canonical
        ]);
    }
}
