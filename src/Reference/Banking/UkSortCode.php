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

    public const CANONICAL_PATTERN = '/^([0-9]{2})([0-9]{2})([0-9]{2})$/';
    public const CANONICAL_MAX_LENGTH = 6;
    public const NORMAL_PATTERN = '/^([0-9]{2})[ -]?([0-9]{2})[ -]?([0-9]{2})$/';
    public const NORMAL_MAX_LENGTH = 8;
    public const EXAMPLE = '12-34-56';

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
