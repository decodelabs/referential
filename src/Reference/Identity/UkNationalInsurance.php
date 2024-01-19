<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Identity;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class UkNationalInsurance implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([A-Z]{2})([0-9]{2})([0-9]{2})([0-9]{2})([A-Z])$/';
    public const CANONICAL_MAX_LENGTH = 9;
    public const NORMAL_PATTERN = '/^([a-zA-Z]{2}) ?([0-9]{2}) ?([0-9]{2}) ?([0-9]{2}) ?([a-zA-Z])$/';
    public const NORMAL_MAX_LENGTH = 13;
    public const EXAMPLE = 'TN311258F';

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
        return Html::{'samp.number.identity.uk-ni'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield ' ';
            yield Html::{'span.value'}($matches[1]);
            yield ' ';
            yield Html::{'span.value'}($matches[2]);
            yield ' ';
            yield Html::{'span.value'}($matches[3]);
            yield ' ';
            yield Html::{'span.value'}($matches[4]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
