<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential\Reference;

use DecodeLabs\Referential\Reference;
use DecodeLabs\Referential\ReferenceTrait;
use DecodeLabs\Tagged\Element;
use DecodeLabs\Tagged\Markup;

class Uuid implements Reference
{
    use ReferenceTrait {
        ReferenceTrait::instantiate as parentInstantiate;
        ReferenceTrait::tryInstantiate as parentTryInstantiate;
        ReferenceTrait::isValid as parentIsValid;
        ReferenceTrait::canonicalize as parentCanonicalize;
        ReferenceTrait::normalize as parentNormalize;
        ReferenceTrait::format as parentFormat;
    }

    public const string CanonicalPattern = '/^([a-z0-9]{8})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{12})$/';
    public const int CanonicalMaxLength = 36;
    public const string NormalPattern = self::CanonicalPattern;
    public const int NormalMaxLength = self::CanonicalMaxLength;
    public const string Example = 'd2516786-28da-c4d4-f701-30df4b2159d9';


    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtolower($value);
        return $value;
    }

    /**
     * @param array<string> $matches
     */
    protected function formatCanonicalMatches(
        array $matches
    ): string {
        return implode('-', $matches);
    }

    /**
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return implode('-', $matches);
    }

    /**
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Element::create('samp.number.uid', function () use ($matches) {
            yield Element::create('span.value', $matches[0]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[1]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[2]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[3]);
            yield Element::create('span.grammar', '-');
            yield Element::create('span.value', $matches[4]);
        }, [
            'title' => $this->canonical
        ]);
    }
}
