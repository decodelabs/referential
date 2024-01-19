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

class Guid implements Reference
{
    use ReferenceTrait {
        ReferenceTrait::instantiate as parentInstantiate;
        ReferenceTrait::tryInstantiate as parentTryInstantiate;
        ReferenceTrait::isValid as parentIsValid;
        ReferenceTrait::canonicalize as parentCanonicalize;
        ReferenceTrait::normalize as parentNormalize;
        ReferenceTrait::format as parentFormat;
    }

    public const CANONICAL_PATTERN = '/^([a-z0-9]{8})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{12})$/';
    public const CANONICAL_MAX_LENGTH = 36;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = 'd2516786-28da-c4d4-f701-30df4b2159d9';



    /**
     * Prepare canonical string
     */
    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtolower($value);
        return $value;
    }

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatCanonicalMatches(
        array $matches
    ): string {
        return implode('-', $matches);
    }

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
        return Html::{'samp.number.guid'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[1]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[2]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[3]);
            yield Html::{'span.grammar'}('-');
            yield Html::{'span.value'}($matches[4]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
