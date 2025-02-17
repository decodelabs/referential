<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential;

use Closure;
use DecodeLabs\Tagged\Markup;
use Stringable;

interface Reference
{
    public const string CanonicalPattern = '';
    public const int CanonicalMaxLength = 0;
    public const string NormalPattern = '';
    public const int NormalMaxLength = 0;
    public const string Example = '';

    /**
     * @return static
     */
    public static function instantiate(
        string|Stringable|null $value
    ): Reference;

    /**
     * @return static|null
     */
    public static function tryInstantiate(
        string|Stringable|null $value
    ): ?Reference;

    public static function isValid(
        string|Stringable|null $value
    ): bool;

    public static function isCanonical(
        string|Stringable|null $value
    ): bool;

    public static function canonicalize(
        string|Stringable|null $value
    ): ?string;

    public static function normalize(
        string|Stringable|null $value
    ): ?string;

    public static function format(
        string|Stringable|null $value
    ): ?Markup;

    public static function getCanonicalPattern(
        bool $wrapped
    ): string;

    public static function getCanonicalMaxLength(): int;

    public static function getNormalPattern(
        bool $wrapped
    ): string;

    public static function getNormalMaxLength(): int;
    public static function getExample(): static;
    public static function getSanitizer(): Closure;
    public static function isGeneric(): bool;

    public function __construct(
        string|Stringable|null $value
    );

    public function validate(): bool;
    public function getRaw(): string;
    public function getCanonical(): ?string;

    public function __toString(): string;
    public function getString(): string;
    public function getHtml(): Markup;
}
