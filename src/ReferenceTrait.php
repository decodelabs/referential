<?php

/**
 * @package Referential
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Referential;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Tagged as Html;
use DecodeLabs\Tagged\Markup;
use Throwable;

trait ReferenceTrait
{
    // const CANONICAL_PATTERN = '';
    // const CANONICAL_MAX_LENGTH = 0;
    // const NORMAL_PATTERN = '';
    // const NORMAL_MAX_LENGTH = 0;
    // const EXAMPLE = '';

    protected string $raw;
    protected ?string $canonical = null;
    protected ?string $formatted = null;
    protected ?Markup $html = null;


    /**
     * Create object if valid
     */
    public static function instantiate(
        ?string $value
    ): static {
        if ($output = static::tryInstantiate($value)) {
            return $output;
        }

        throw Exceptional::InvalidArgument('Value must not be null');
    }

    public static function tryInstantiate(
        ?string $value
    ): ?static {
        $output = new static($value);

        if (!$output->validate()) {
            return null;
        }

        return $output;
    }

    /**
     * Generate and validate
     */
    public static function isValid(
        ?string $value
    ): bool {
        return (bool)static::tryInstantiate($value);
    }

    /**
     * Is reference in canonical format?
     */
    public static function isCanonical(
        ?string $value
    ): bool {
        if (!$ref = static::tryInstantiate($value)) {
            return false;
        }

        return $value === $ref->getCanonical();
    }

    /**
     * Generate and convert to canonical
     */
    public static function canonicalize(
        ?string $value
    ): ?string {
        if (!$ref = static::tryInstantiate($value)) {
            return null;
        }

        return $ref->getCanonical();
    }

    /**
     * Generate and format
     */
    public static function normalize(
        ?string $value
    ): ?string {
        if (!$ref = static::tryInstantiate($value)) {
            return null;
        }

        return $ref->getString();
    }

    /**
     * Generate and format as HTML
     */
    public static function format(
        ?string $value
    ): ?Markup {
        if (!$ref = static::tryInstantiate($value)) {
            return null;
        }

        return $ref->getHtml();
    }



    /**
     * Get matchable canonical pattern
     */
    public static function getCanonicalPattern(
        bool $wrapped
    ): string {
        if (!defined('static::CANONICAL_PATTERN')) {
            throw Exceptional::Setup('Canonical pattern has not been defined');
        }

        $output = static::CANONICAL_PATTERN;

        if (!$wrapped) {
            $output = substr((string)$output, 1, -1);
        }

        return $output;
    }

    /**
     * Get canonical max string length
     */
    public static function getCanonicalMaxLength(): int
    {
        if (!defined('static::CANONICAL_MAX_LENGTH')) {
            throw Exceptional::Setup('Canonical max length has not been defined');
        }

        return static::CANONICAL_MAX_LENGTH;
    }

    /**
     * Get matchable normal pattern
     */
    public static function getNormalPattern(
        bool $wrapped
    ): string {
        if (!defined('static::NORMAL_PATTERN')) {
            throw Exceptional::Setup('Normal pattern has not been defined');
        }

        $output = static::NORMAL_PATTERN;

        if (!$wrapped) {
            $output = substr((string)$output, 1, -1);
        }

        return $output;
    }

    /**
     * Get normal max string length
     */
    public static function getNormalMaxLength(): int
    {
        if (!defined('static::NORMAL_MAX_LENGTH')) {
            throw Exceptional::Setup('Normal max length has not been defined');
        }

        return static::NORMAL_MAX_LENGTH;
    }


    /**
     * Get example instance
     */
    public static function getExample(): static
    {
        if (!defined('static::EXAMPLE')) {
            throw Exceptional::Setup('Example has not been defined');
        }

        return new static(static::EXAMPLE);
    }


    /**
     * Get sanitizer for validator
     */
    public static function getSanitizer(): Closure
    {
        return function (
            ?string $value
        ): ?string {
            $output = static::canonicalize($value);

            if ($output === null) {
                return $value;
            }

            return $output;
        };
    }

    /**
     * Is this a generic reference?
     */
    public static function isGeneric(): bool
    {
        return false;
    }




    /**
     * Init with any value
     */
    public function __construct(
        ?string $value
    ) {
        $this->raw = (string)$value;
        $this->canonical = $this->prepareCanonical($this->raw);
    }


    /**
     * Valid if canonical has been calculated
     */
    public function validate(): bool
    {
        return $this->canonical !== null;
    }

    /**
     * Get raw input
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    /**
     * Get canonicalized version
     */
    public function getCanonical(): ?string
    {
        return $this->canonical;
    }





    /**
     * Prepare canonical value
     */
    protected function prepareCanonical(
        string $value
    ): ?string {
        $value = $this->prepareCanonicalString($value);

        if (!$matches = $this->matchParts($value)) {
            return null;
        }

        return $this->formatCanonicalMatches($matches);
    }

    /**
     * Prepare canonical string
     */
    protected function prepareCanonicalString(
        string $value
    ): string {
        $value = strtoupper($value);
        $value = preg_replace('/[^A-Z0-9]/', '', $value);

        return (string)$value;
    }

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatCanonicalMatches(
        array $matches
    ): string {
        return implode($matches);
    }




    /**
     * Shortcut to format
     */
    public function __toString(): string
    {
        return $this->getString();
    }


    /**
     * Attempt to convert to visual format
     */
    public function getString(): string
    {
        if ($this->canonical === null) {
            return $this->raw;
        }

        if ($this->formatted === null) {
            try {
                $this->formatted = $this->prepareNormalized($this->canonical);
            } catch (Throwable $e) {
                return $this->raw;
            }
        }

        return $this->formatted;
    }


    /**
     * Convert canonical to formatted value
     */
    protected function prepareNormalized(
        string $value
    ): string {
        if (!$matches = $this->matchParts($value)) {
            throw Exceptional::UnexpectedValue('Unable to match canonical value', null, $value);
        }

        return $this->formatNormalizedMatches($matches);
    }

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatNormalizedMatches(
        array $matches
    ): string {
        return $this->formatCanonicalMatches($matches);
    }


    /**
     * Attempt to convert to HTML
     */
    public function getHtml(): Markup
    {
        $this->checkTagged();

        if ($this->html === null) {
            if ($this->canonical === null) {
                $this->html = $this->prepareRawErrorHtml($this->raw);
            } else {
                try {
                    $this->html = $this->prepareHtml($this->canonical);
                } catch (Throwable $e) {
                    $this->html = $this->prepareRawErrorHtml($this->raw);
                }
            }

            $this->html = Html::raw((string)$this->html);
        }

        return $this->html;
    }


    /**
     * Convert canonical to formatted value
     */
    protected function prepareHtml(
        string $value
    ): Markup {
        if (!$matches = $this->matchParts($value)) {
            throw Exceptional::UnexpectedValue('Unable to match canonical value', null, $value);
        }

        return $this->formatHtmlMatches($matches);
    }

    /**
     * Combine match parts
     *
     * @param array<string> $matches
     */
    protected function formatHtmlMatches(
        array $matches
    ): Markup {
        return Html::{'samp.number'}($this->formatCanonicalMatches($matches));
    }

    /**
     * Create error HTML
     */
    protected function prepareRawErrorHtml(
        string $raw
    ): Markup {
        return Html::{'samp.error.invalid'}($raw);
    }

    /**
     * Check for tagged
     */
    protected function checkTagged(): void
    {
        if (!class_exists(Html::class)) {
            throw Exceptional::ComponentUnavailable(
                'Unable to generate HTML - Tagged library is not available'
            );
        }
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

        array_shift($matches);
        return $matches;
    }
}
