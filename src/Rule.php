<?php
declare(strict_types=1);

namespace Fyre\Validation;

use Closure;
use Fyre\Utility\Traits\MacroTrait;

use function array_key_exists;
use function ctype_alnum;
use function ctype_alpha;
use function ctype_digit;
use function ctype_print;
use function filter_var;
use function implode;
use function in_array;
use function is_scalar;
use function preg_match;
use function strlen;
use function strtolower;

use const FILTER_FLAG_EMAIL_UNICODE;
use const FILTER_FLAG_IPV4;
use const FILTER_FLAG_IPV6;
use const FILTER_NULL_ON_FAILURE;
use const FILTER_VALIDATE_BOOLEAN;
use const FILTER_VALIDATE_EMAIL;
use const FILTER_VALIDATE_FLOAT;
use const FILTER_VALIDATE_INT;
use const FILTER_VALIDATE_IP;

/**
 * Rule
 */
class Rule
{
    use MacroTrait;

    protected string|null $message = null;

    protected string|null $type = null;

    /**
     * Create an "alpha" Rule.
     *
     * @return Rule The Rule.
     */
    public static function alpha(): static
    {
        return new static(
            fn(mixed $value): bool => is_scalar($value) && ctype_alpha((string) $value),
            __FUNCTION__
        );
    }

    /**
     * Create an "alpha-numeric" Rule.
     *
     * @return Rule The Rule.
     */
    public static function alphaNumeric(): static
    {
        return new static(
            fn(mixed $value): bool => is_scalar($value) && ctype_alnum((string) $value),
            __FUNCTION__
        );
    }

    /**
     * Create an "ASCII" Rule.
     *
     * @return Rule The Rule.
     */
    public static function ascii(): static
    {
        return new static(
            fn(mixed $value): bool => is_scalar($value) && ctype_print((string) $value),
            __FUNCTION__
        );
    }

    /**
     * Create a "between" Rule.
     *
     * @param int $min The minimum value.
     * @param int $max The maximum value.
     * @return Rule The Rule.
     */
    public static function between(int $min, int $max): static
    {
        return new static(
            fn(mixed $value): bool => $value >= $min && $value <= $max,
            __FUNCTION__,
            [$min, $max]
        );
    }

    /**
     * Create a "boolean" Rule.
     *
     * @return Rule The Rule.
     */
    public static function boolean(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create a "date" Rule.
     *
     * @return Rule The Rule.
     */
    public static function date(): static
    {
        return new static(
            function(mixed $value): bool {
                return !$value || $this->typeParser->use('date')->parse($value) !== null;
            },
            __FUNCTION__
        );
    }

    /**
     * Create a "date/time" Rule.
     *
     * @return Rule The Rule.
     */
    public static function dateTime(): static
    {
        return new static(
            function(mixed $value): bool {
                return !$value || $this->typeParser->use('datetime')->parse($value) !== null;
            },
            __FUNCTION__
        );
    }

    /**
     * Create a "decimal" Rule.
     *
     * @return Rule The Rule.
     */
    public static function decimal(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create a "differs" Rule.
     *
     * @param string $field The other field name.
     * @return Rule The Rule.
     */
    public static function differs(string $field): static
    {
        return new static(
            fn($value, array $data): bool => $value !== $data[$field] ?? null,
            __FUNCTION__,
            [$field]
        );
    }

    /**
     * Create an "email" Rule.
     *
     * @return Rule The Rule.
     */
    public static function email(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE | FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create an "empty" Rule.
     *
     * @return Rule The Rule.
     */
    public static function empty(): static
    {
        return new static(
            fn(): bool => false,
            __FUNCTION__
        );
    }

    /**
     * Create an "equals" Rule.
     *
     * @param mixed $other The value to compare against.
     * @return Rule The Rule.
     */
    public static function equals(mixed $other): static
    {
        return new static(
            fn(mixed $value): bool => $value == $other,
            __FUNCTION__,
            [$other]
        );
    }

    /**
     * Create an "exact length" Rule.
     *
     * @param int $length The length.
     * @return Rule The Rule.
     */
    public static function exactLength(int $length): static
    {
        return new static(
            fn(mixed $value): bool => strlen((string) $value) === $length,
            __FUNCTION__,
            [$length]
        );
    }

    /**
     * Create a "greater than" Rule.
     *
     * @param int $min The minimum value.
     * @return Rule The Rule.
     */
    public static function greaterThan(int $min): static
    {
        return new static(
            fn(mixed $value): bool => $value > $min,
            __FUNCTION__,
            [$min]
        );
    }

    /**
     * Create a "greater than or equals" Rule.
     *
     * @param int $min The minimum value.
     * @return Rule The Rule.
     */
    public static function greaterThanOrEquals(int $min): static
    {
        return new static(
            fn(mixed $value): bool => $value >= $min,
            __FUNCTION__,
            [$min]
        );
    }

    /**
     * Create an "in" Rule.
     *
     * @param array $values The values.
     * @return Rule The Rule.
     */
    public static function in(array $values): static
    {
        return new static(
            fn(mixed $value): bool => in_array($value, $values),
            __FUNCTION__,
            [implode(', ', $values)]
        );
    }

    /**
     * Create an "integer" Rule.
     *
     * @return Rule The Rule.
     */
    public static function integer(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create an "IP" Rule.
     *
     * @return Rule The Rule.
     */
    public static function ip(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create an "IPv4" Rule.
     *
     * @return Rule The Rule.
     */
    public static function ipv4(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create an "IPv6" Rule.
     *
     * @return Rule The Rule.
     */
    public static function ipv6(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * Create a "less than" Rule.
     *
     * @param int $max The maximum value.
     * @return Rule The Rule.
     */
    public static function lessThan(int $max): static
    {
        return new static(
            fn(mixed $value): bool => $value < $max,
            __FUNCTION__,
            [$max]
        );
    }

    /**
     * Create a "less than or equals" Rule.
     *
     * @param int $max The maximum value.
     * @return Rule The Rule.
     */
    public static function lessThanOrEquals(int $max): static
    {
        return new static(
            fn(mixed $value): bool => $value <= $max,
            __FUNCTION__,
            [$max]
        );
    }

    /**
     * Create a "matches" Rule.
     *
     * @param string $field The other field name.
     * @return Rule The Rule.
     */
    public static function matches(string $field): static
    {
        return new static(
            fn($value, array $data): bool => $value === $data[$field] ?? null,
            __FUNCTION__,
            [$field]
        );
    }

    /**
     * Create a "maximum length" Rule.
     *
     * @param int $length The length.
     * @return Rule The Rule.
     */
    public static function maxLength(int $length): static
    {
        return new static(
            fn(mixed $value): bool => strlen((string) $value) <= $length,
            __FUNCTION__,
            [$length]
        );
    }

    /**
     * Create a "minimum length" Rule.
     *
     * @param int $length The length.
     * @return Rule The Rule.
     */
    public static function minLength(int $length): static
    {
        return new static(
            fn(mixed $value): bool => strlen((string) $value) >= $length,
            __FUNCTION__,
            [$length]
        );
    }

    /**
     * Create a "natural number" Rule.
     *
     * @return Rule The Rule.
     */
    public static function naturalNumber(): static
    {
        return new static(
            fn(mixed $value): bool => is_scalar($value) && ctype_digit((string) $value),
            __FUNCTION__
        );
    }

    /**
     * Create a "not empty" Rule.
     *
     * @return Rule The Rule.
     */
    public static function notEmpty(): static
    {
        return new static(
            fn(mixed $value): bool => $value !== null && $value !== '' && $value !== [],
            __FUNCTION__,
            skipEmpty: false
        );
    }

    /**
     * Create a "regular expression" Rule.
     *
     * @param string $regex The regular expression.
     * @return Rule The Rule.
     */
    public static function regex(string $regex): static
    {
        return new static(
            fn(mixed $value): bool => preg_match($regex, (string) $value) === 1,
            __FUNCTION__,
            [$regex]
        );
    }

    /**
     * Create a "required" Rule.
     *
     * @return Rule The Rule.
     */
    public static function required(): static
    {
        return new static(
            fn(mixed $value, array $data, string $field): bool => array_key_exists($field, $data) &&
                $value !== null &&
                $value !== '' &&
                $value !== [],
            __FUNCTION__,
            skipEmpty: false,
            skipNotSet: false
        );
    }

    /**
     * Create a "require presence" Rule.
     *
     * @param bool $mustBeSet Whether the key must be set.
     * @return Rule The Rule.
     */
    public static function requirePresence(bool $mustBeSet = false): static
    {
        return new static(
            fn(mixed $value, array $data, string $field): bool => array_key_exists($field, $data),
            __FUNCTION__,
            skipEmpty: false,
            skipNotSet: false
        );
    }

    /**
     * Create a "time" Rule.
     *
     * @return Rule The Rule.
     */
    public static function time(): static
    {
        return new static(
            function(mixed $value): bool {
                return !$value || $this->typeParser->use('time')->parse($value) !== null;
            },
            __FUNCTION__
        );
    }

    /**
     * Create a "URL" Rule.
     *
     * @return Rule The Rule.
     */
    public static function url(): static
    {
        return new static(
            fn(mixed $value): bool => filter_var($value, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE) !== null,
            __FUNCTION__
        );
    }

    /**
     * New Rule constructor.
     *
     * @param Closure $callback The callback.
     * @param string|null $name The rule name.
     * @param array $arguments The callback arguments.
     * @param bool $skipEmpty Whether to skip validation for empty values.
     * @param bool $skipNotSet Whether to skip validation for unset values.
     */
    public function __construct(
        protected Closure $callback,
        protected string|null $name = null,
        protected array $arguments = [],
        protected bool $skipEmpty = true,
        protected bool $skipNotSet = true
    ) {}

    /**
     * Check the type of rule.
     *
     * @param string $type The type to test.
     * @return bool TRUE if the types match, otherwise FALSE.
     */
    public function checkType(string|null $type = null): bool
    {
        return !$type || !$this->type || strtolower($type) === $this->type;
    }

    /**
     * Get the callback arguments.
     *
     * @return array The callback arguments.
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Get the callback.
     *
     * @return Closure The callback.
     */
    public function getCallback(): Closure
    {
        return $this->callback;
    }

    /**
     * Get the rule error message.
     *
     * @return string|null The error message.
     */
    public function getMessage(): string|null
    {
        return $this->message;
    }

    /**
     * Get the rule name.
     *
     * @return string|null The rule name.
     */
    public function getName(): string|null
    {
        return $this->name;
    }

    /**
     * Set the rule error message.
     *
     * @param string $error The error message.
     * @return Rule The Rule.
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the rule type.
     *
     * @param string $type The rule type.
     * @return Rule The Rule.
     */
    public function setType(string $type): static
    {
        $this->type = strtolower($type);

        return $this;
    }

    /**
     * Determine whether to skip empty values.
     *
     * @return bool TRUE if empty values can be skipped, otherwise FALSE.
     */
    public function skipEmpty(): bool
    {
        return $this->skipEmpty;
    }

    /**
     * Determine whether to skip unset values.
     *
     * @return bool TRUE if unset values can be skipped, otherwise FALSE.
     */
    public function skipNotSet(): bool
    {
        return $this->skipNotSet;
    }
}
