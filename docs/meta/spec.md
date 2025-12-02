# Referential — Package Specification

> **Cluster:** `data`
> **Language:** `php`
> **Milestone:** `m5`
> **Repo:** `https://github.com/decodelabs/referential`
> **Role:** Ref ID parsing

## Overview

### Purpose

Referential provides a framework for finding, parsing, inspecting, and formatting reference IDs. It enables a consistent way of working with keys across multiple data sources and formats, supporting various reference types including UUIDs, email addresses, banking identifiers, music industry codes, and more.

The package abstracts the complexity of parsing and validating different reference formats behind a unified interface, allowing applications to handle diverse ID types consistently.

### Non-Goals

- Referential does not provide database persistence or ORM integration.
- It does not implement reference resolution (looking up entities by ID).
- It does not provide reference generation (creating new IDs).
- It does not handle reference relationships or hierarchies.

## Role in the Ecosystem

### Cluster & Positioning

Referential belongs to the **data** cluster, focusing on structured data handling and validation. It complements other data-focused packages like `collections`, `supermodel`, and `exemplar` by providing standardized reference ID handling.

### Usage Contexts

- **Data validation**: Validating user input for various reference types (emails, UUIDs, banking codes, etc.)
- **Data normalization**: Converting reference IDs to canonical formats for storage or comparison
- **Display formatting**: Formatting reference IDs for human-readable output
- **HTML generation**: Generating semantic HTML markup for reference IDs (when Tagged is available)
- **API interfaces**: Parsing and validating reference IDs in API requests/responses

## Public Surface

### Key Types

- **`Reference`** (interface): The core interface defining the contract for all reference types. Provides static factory methods, validation, canonicalization, normalization, and formatting capabilities.

- **`ReferenceTrait`** (trait): Default implementation of the `Reference` interface, providing common functionality for parsing, validation, and formatting. Classes implementing `Reference` typically use this trait.

### Main Entry Points

**Static Factory Methods:**
- `Reference::instantiate(string|Stringable|null $value): Reference` — Creates a reference instance, throwing on invalid input
- `Reference::tryInstantiate(string|Stringable|null $value): ?Reference` — Creates a reference instance, returning null on invalid input
- `Reference::isValid(string|Stringable|null $value): bool` — Checks if a value is valid for the reference type
- `Reference::isCanonical(string|Stringable|null $value): bool` — Checks if a value is already in canonical form
- `Reference::canonicalize(string|Stringable|null $value): ?string` — Converts a value to canonical form
- `Reference::normalize(string|Stringable|null $value): ?string` — Converts a value to normalized (display) form
- `Reference::format(string|Stringable|null $value): ?Markup` — Formats a value as HTML markup (requires Tagged)

**Instance Methods:**
- `$reference->validate(): bool` — Validates the current reference value
- `$reference->getRaw(): string` — Returns the original input value
- `$reference->getCanonical(): ?string` — Returns the canonical form
- `$reference->getString(): string` — Returns the normalized (display) form
- `$reference->getHtml(): Markup` — Returns HTML markup (requires Tagged)

**Reference Implementations:**

The package includes numerous reference type implementations organized by domain:

- **Generic**: `NumericId`, `Slug`
- **Identity**: `InitialKey`, `Uuid`
- **Communication**: `Email`, `Domain`, `AtHandle`
- **Banking**: `Iban`, `RoutingNumber`, `Swift`, `UkSortCode`
- **Commerce**: `Upc`
- **Identity**: `UkNationalInsurance`
- **Music**: `CatalogueNumber`, `GenericTrackReference`, `Isrc`, `IsrcRange`, `Iswc`, `PrsTunecode`

Each implementation defines:
- `CanonicalPattern`: Regex pattern for the canonical form
- `CanonicalMaxLength`: Maximum length for canonical form
- `NormalPattern`: Regex pattern for the normalized (display) form
- `NormalMaxLength`: Maximum length for normalized form
- `Example`: Example value for the reference type

## Dependencies

### Decode Labs

- **`decodelabs/exceptional`**: Used for exception handling throughout the package.

### External

- **PHP**: See `composer.json` for supported PHP versions.

### Optional

- **`decodelabs/tagged`**: Detected at runtime if installed, used for HTML formatting via `getHtml()` and `format()` methods. If not available, these methods will throw `ComponentUnavailable` exceptions.

## Behaviour & Contracts

### Invariants

- A reference instance always contains a raw value (may be empty string).
- The canonical form is computed from the raw value during construction.
- If validation fails, `getCanonical()` returns `null`.
- The normalized form is computed lazily from the canonical form.
- HTML formatting requires Tagged to be available.

### Input & Output Contracts

**Input:**
- All factory methods accept `string|Stringable|null` values.
- Null values are converted to empty strings internally.
- Stringable objects are converted to strings.

**Output:**
- `canonicalize()` and `normalize()` return `?string` (null if invalid).
- `format()` returns `?Markup` (null if invalid, requires Tagged).
- Instance methods return validated data or throw exceptions.

**Canonical Form:**
- Represents the reference in its most compact, standardized format.
- Used for storage, comparison, and validation.
- Typically uppercase and stripped of formatting characters.

**Normalized Form:**
- Represents the reference in a human-readable format.
- Used for display purposes.
- May include formatting characters (hyphens, spaces, etc.).

## Error Handling

- **Invalid input**: `instantiate()` throws `InvalidArgument` exceptions for null values that cannot be instantiated.
- **Invalid reference**: `tryInstantiate()` returns `null` for invalid values; `isValid()` returns `false`.
- **Missing constants**: Methods accessing undefined class constants throw `Setup` exceptions.
- **Tagged unavailable**: `getHtml()` and `format()` throw `ComponentUnavailable` exceptions if Tagged is not installed.
- **Parsing errors**: Internal parsing failures result in `null` canonical forms, causing validation to fail.

## Configuration & Extensibility

### Creating Custom Reference Types

To create a custom reference type:

1. Implement the `Reference` interface.
2. Use the `ReferenceTrait` for default functionality.
3. Define the required constants:
   - `CanonicalPattern`: Regex pattern for canonical matching
   - `CanonicalMaxLength`: Maximum canonical length
   - `NormalPattern`: Regex pattern for normalized matching
   - `NormalMaxLength`: Maximum normalized length
   - `Example`: Example value

4. Optionally override protected methods:
   - `prepareCanonicalString()`: Pre-process input before canonical matching
   - `formatCanonicalMatches()`: Format matched parts into canonical form
   - `formatNormalizedMatches()`: Format matched parts into normalized form
   - `formatHtmlMatches()`: Format matched parts into HTML markup
   - `matchParts()`: Custom matching logic (rarely needed)

### Generic References

Some reference types (e.g., `NumericId`, `Slug`) are marked as "generic" via `isGeneric(): bool`. This indicates they can represent a wide range of values rather than a specific format.

## Interactions with Other Packages

- **Exceptional**: Used for all exception handling.
- **Tagged**: Optional dependency for HTML formatting. Methods gracefully handle its absence.
- **Other data packages**: Referential can be used alongside `collections`, `supermodel`, and other data packages to provide reference ID handling capabilities.

## Usage Examples

### Basic Validation

```php
use DecodeLabs\Referential\Reference\Uuid;

// Check if a value is valid
if (Uuid::isValid('d2516786-28da-c4d4-f701-30df4b2159d9')) {
    echo "Valid UUID";
}

// Create an instance (throws on invalid)
$uuid = Uuid::instantiate('d2516786-28da-c4d4-f701-30df4b2159d9');

// Try to create (returns null on invalid)
$uuid = Uuid::tryInstantiate('invalid');
if ($uuid === null) {
    echo "Invalid UUID";
}
```

### Canonicalization

```php
use DecodeLabs\Referential\Reference\Email;

// Convert to canonical form
$canonical = Email::canonicalize('Test@Example.COM');
// Returns: "test@example.com"

// Check if already canonical
if (Email::isCanonical('test@example.com')) {
    echo "Already canonical";
}
```

### Normalization

```php
use DecodeLabs\Referential\Reference\Uuid;

// Get normalized (display) form
$normalized = Uuid::normalize('d251678628dac4d4f70130df4b2159d9');
// Returns: "d2516786-28da-c4d4-f701-30df4b2159d9"

// Or via instance
$uuid = Uuid::instantiate('d2516786-28da-c4d4-f701-30df4b2159d9');
echo $uuid->getString(); // Normalized form
echo $uuid->getCanonical(); // Canonical form
```

### HTML Formatting (requires Tagged)

```php
use DecodeLabs\Referential\Reference\Email;

// Format as HTML
$html = Email::format('test@example.com');
// Returns Tagged Markup object

// Or via instance
$email = Email::instantiate('test@example.com');
$html = $email->getHtml();
```

### Banking References

```php
use DecodeLabs\Referential\Reference\Banking\Iban;

$iban = Iban::instantiate('BE71 0961 2345 6769 45');
echo $iban->getString(); // "BE71 0961 2345 6769 45"
echo $iban->getCanonical(); // Canonical form without spaces
```

### Music Industry References

```php
use DecodeLabs\Referential\Reference\Music\Isrc;

$isrc = Isrc::instantiate('US-RC1-76-07839');
echo $isrc->getString(); // "US-RC1-76-07839"
echo $isrc->getCanonical(); // "USRC17607839"
```

## Implementation Notes (for Contributors)

### Pattern Matching

- Patterns use regex with capturing groups to extract parts.
- The `matchParts()` method extracts parts from the canonical value.
- Parts are then formatted according to the reference type's requirements.

### Canonical vs Normal Forms

- Canonical form is always computed during construction.
- Normal form is computed lazily on first access.
- Both forms are cached in instance properties.

### HTML Generation

- HTML generation requires Tagged to be available.
- The `checkTagged()` method verifies availability before generating HTML.
- Each reference type can customize HTML output via `formatHtmlMatches()`.

### Generic References

- Generic references (like `NumericId`) can represent a wide range of values.
- They are marked via `isGeneric(): bool` returning `true`.
- This distinction may be useful for UI components or validation rules.

## Testing & Quality

**Current Status:**
- Code quality: 3.5/5
- README quality: 3/5
- Documentation: 0/5 (no formal docs yet)
- Tests: 0/5 (no test suite yet)

**Testing Considerations:**
- Each reference type should have tests covering:
  - Valid input variations
  - Invalid input handling
  - Canonical form generation
  - Normalized form generation
  - HTML formatting (when Tagged available)
  - Edge cases (empty strings, null, special characters)

## Roadmap & Future Ideas

- **Additional reference types**: More domain-specific reference types (e.g., ISBN, credit card numbers, tax IDs)
- **Reference resolution**: Optional integration with entity lookup systems
- **Reference generation**: Utilities for generating valid reference IDs
- **Validation rules**: More sophisticated validation (e.g., checksum validation for IBANs)
- **Internationalization**: Support for locale-specific formatting
- **Performance**: Caching and optimization for high-volume use cases

## References

- Package repository: https://github.com/decodelabs/referential
- Composer package: https://packagist.org/packages/decodelabs/referential
- Related packages:
  - `decodelabs/exceptional` — Exception handling
  - `decodelabs/tagged` — HTML markup generation (optional)

