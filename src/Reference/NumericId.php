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

class NumericId implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([0-9]+)$/';
    protected const CanonicalMaxLength = 32;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = '123456';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.numeric-id'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
        }, [
            'title' => $this->canonical
        ]);
    }

    public static function isGeneric(): bool
    {
        return true;
    }
}
