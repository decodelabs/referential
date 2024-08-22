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

class Swift implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([a-zA-Z]{4})([a-zA-Z]{2})([0-9a-zA-Z]{2})([0-9a-zA-Z]{3})?$/';
    protected const CanonicalMaxLength = 11;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = 'BOFAUS3N';


    /**
     * Convert canonical to html value
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number.banking.swift'}(function () use ($matches) {
            yield Html::{'span.value'}($matches[0]);
            yield Html::{'span.value'}($matches[1]);
            yield Html::{'span.value'}($matches[2]);
            yield Html::{'?span.value'}($matches[3] ?? null);
        }, [
            'title' => $this->canonical
        ]);
    }
}
