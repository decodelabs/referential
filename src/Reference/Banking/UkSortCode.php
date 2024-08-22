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

class UkSortCode implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([0-9]{2})([0-9]{2})([0-9]{2})$/';
    protected const CanonicalMaxLength = 6;
    protected const NormalPattern = '/^([0-9]{2})[ -]?([0-9]{2})[ -]?([0-9]{2})$/';
    protected const NormalMaxLength = 8;
    protected const Example = '12-34-56';

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode('-', $matches);
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.banking.uk-sort-code'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[1]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[2]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
