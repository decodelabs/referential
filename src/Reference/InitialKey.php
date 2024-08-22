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

class InitialKey implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([A-Z])([A-Z0-9]{2,})$/';
    protected const CanonicalMaxLength = 12;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = 'MTR1';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.initial'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0] . $matches[1]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
