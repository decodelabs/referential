<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Banking;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class RoutingNumber implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([0-9]{4})([0-9]{4})([0-9]{1})$/';
    protected const CanonicalMaxLength = 9;
    protected const NormalPattern = '/^([0-9]{4}) ?([0-9]{4}) ?([0-9]{1})$/';
    protected const NormalMaxLength = 11;
    protected const Example = '061000104';


    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode(' ', $matches);
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.banking.routing'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield ' ';
            yield Html::{'span.value'}($matches[1]);
            yield ' ';
            yield Html::{'span.value'}($matches[2]);
        });
    }
}
