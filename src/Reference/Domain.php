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

class Domain implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([^@\s\.]+\.[^@\s]{2,})$/';
    public const CANONICAL_MAX_LENGTH = 2048;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = 'example.com';

    /**
     * Prepare canonical string
     */
    protected function prepareCanonicalString(
        string $value
    ): string {
        return strtolower($value);
    }

    /**
     * Convert canonical to formatted value
     */
    protected function prepareNormalized(
        string $value
    ): string {
        return trim($value);
    }

    /**
     * Convert canonical to formatted value
     */
    protected function prepareHtml(
        string $value
    ): Markup {
        return Html::{'a.domain'}($this->prepareNormalized($value), [
            'href' => 'https://' . $value,
            'title' => $this->canonical
        ]);
    }
}
