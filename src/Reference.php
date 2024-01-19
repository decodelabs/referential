<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential;

use Closure;
use DecodeLabs\Tagged\Markup;

interface Reference
{
    /**
     * @return static
     */
    public static function instantiate(
        ?string $value
    ): Reference;

    /**
     * @return static|null
     */
    public static function tryInstantiate(
        ?string $value
    ): ?Reference;

    public static function isValid(
        ?string $value
    ): bool;

    public static function isCanonical(
        ?string $value
    ): bool;

    public static function canonicalize(
        ?string $value
    ): ?string;

    public static function normalize(
        ?string $value
    ): ?string;

    public static function format(
        ?string $value
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
        ?string $value
    );

    public function validate(): bool;
    public function getRaw(): string;
    public function getCanonical(): ?string;

    public function __toString(): string;
    public function getString(): string;
    public function getHtml(): Markup;
}
