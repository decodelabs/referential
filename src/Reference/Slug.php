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

class Slug implements Reference
{
    use ReferenceTrait;

    public const string CanonicalPattern = '/^([a-z0-9-]{3,})$/';
    public const int CanonicalMaxLength = 128;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'interesting-article-title';


    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtolower($value);
        $value = str_replace([' ', '_'], '-', $value);
        $value = preg_replace('/[^a-z0-9-]/', '', $value);
        return (string)$value;
    }

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.slug', $matches[0], [
            'title' => $this->canonical
        ]);
    }

    public static function isGeneric(): bool
    {
        return true;
    }
}
