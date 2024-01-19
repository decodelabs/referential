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

class GenericTrackReference implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = '/^([A-Z0-9]{3,})$/';
    public const CANONICAL_MAX_LENGTH = 32;
    public const NORMAL_PATTERN = self::CANONICAL_PATTERN;
    public const NORMAL_MAX_LENGTH = self::CANONICAL_MAX_LENGTH;
    public const EXAMPLE = '123456';

    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.music.reference'}(function () use ($matches) {
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
