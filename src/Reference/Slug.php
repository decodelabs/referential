<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class Slug implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([a-z0-9-]{3,})$/';
    protected const CanonicalMaxLength = 128;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = 'interesting-article-title';

    /**
     * Prepare canonical string
     */
    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtolower($value);
        $value = str_replace([' ', '_'], '-', $value);
        $value = preg_replace('/[^a-z0-9-]/', '', $value);
        return (string)$value;
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.slug'}($matches[0], [
            'title' => $this->canonical
        ]);
    }

    public static function isGeneric(): bool
    {
        return true;
    }
}
