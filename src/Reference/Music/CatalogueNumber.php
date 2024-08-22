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

class CatalogueNumber implements Reference
{
    use ReferenceTrait;

    protected const CanonicalPattern = '/^([A-Z])([A-Z0-9 ]{2,})$/';
    protected const CanonicalMaxLength = 32;
    protected const NormalPattern = self::CanonicalPattern;
    protected const NormalMaxLength = self::CanonicalMaxLength;
    protected const Example = 'XCD023';

    /**
     * Prepare canonical string
     */
    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtoupper($value);
        $value = (string)preg_replace('/[^A-Z0-9]/', '', $value);
        $value = (string)preg_replace('/([A-Z])([0]+)([1-9]+)/', '$1$3', $value);

        return $value;
    }

    /**
     * Convert canonical to formatted value
     */
    protected function prepareNormalized(
        string $value
    ): string {
        return strtoupper(trim($this->raw));
    }

    /**
     * Convert canonical to formatted value
     */
    protected function prepareHtml(
        string $value
    ): Markup {
        return Html::{'samp.number.music.catalogue'}(function () use ($value) {
            yield Html::{'span.value'}($this->prepareNormalized($value));
        }, [
            'title' => $this->canonical
        ]);
    }
}
