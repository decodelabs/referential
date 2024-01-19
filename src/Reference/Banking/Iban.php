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

class Iban implements Reference
{
    use ReferenceTrait;

    public const CANONICAL_PATTERN = self::NORMAL_PATTERN;
    public const CANONICAL_MAX_LENGTH = self::NORMAL_MAX_LENGTH;
    public const NORMAL_PATTERN = '/^([A-Z]{2}[ \-]?[0-9]{2})(?=(?:[ \-]?[A-Z0-9]){9,30}$)((?:[ \-]?[A-Z0-9]{3,5}){2,7})([ \-]?[A-Z0-9]{1,3})?$/';
    public const NORMAL_MAX_LENGTH = 50;
    public const EXAMPLE = 'BE71 0961 2345 6769 45';

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
        return Html::{'samp.number.banking.iban'}(function () use ($matches) {
            yield Html::{'span.value'}(array_shift($matches));

            foreach ($matches as $part) {
                yield ' ';
                yield Html::{'span.value'}($part);
            }
        }, [
            'title' => $this->canonical
        ]);
    }

    /**
     * Match token parts
     *
     * @return array<string>|null
     */
    protected function matchParts(
        string $value
    ): ?array {
        if (!preg_match($this->getCanonicalPattern(true), $value, $matches)) {
            return null;
        }

        $output = str_split($matches[2], 4);
        array_unshift($output, $matches[1]);

        return $output;
    }
}
