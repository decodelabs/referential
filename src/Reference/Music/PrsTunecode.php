<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference\Music;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;

class PrsTunecode implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([0-9]{4,6})([a-zA-Z0-9])([a-zA-Z])$/';
    public const CANONICAL_MAX_LENGTH = 8;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = '083657CV';

    /**
     * Prepare canonical string
     */
    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtoupper($value);
        $value = (string)preg_replace('/[^A-Z0-9]/', '', $value);

        $value = str_pad($value, 8, '0', STR_PAD_LEFT);

        return $value;
    }

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.music.prs-tunecode'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield Html::{'span.value'}($matches[1] . $matches[2]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
