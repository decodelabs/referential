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

class Email implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([^@\s]+)(@)([^@\s\.]+\.[^@\s]+)$/';
    public const int CanonicalMaxLength = 2048;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'test@example.com';

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
        return Element::create('a.email', $this->prepareNormalized($value), [
            'href' => 'mailto:' . $value
        ]);
    }
}
