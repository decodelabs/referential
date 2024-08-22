<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Commerce;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class Upc implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([0-9]{12,13})$/';
    protected const CanonicalMaxLength = 13;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = '0799439112766';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.commerce.upc'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
