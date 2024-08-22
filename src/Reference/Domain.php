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

    protected const CanonicalPattern = '/^([^@\s\.]+\.[^@\s]{2,})$/';
    protected const CanonicalMaxLength = 2048;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = 'example.com';

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
