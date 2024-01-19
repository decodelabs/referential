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

    public const CANONICAL_PATTERN = '/^([a-z0-9-]{3,})$/';
    public const CANONICAL_MAX_LENGTH = 128;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = 'interesting-article-title';

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
