<?php
declare(strict_types=1);

namespace Fyre\Validation;

use Closure;
use Fyre\Lang\Lang;
use Fyre\Validation\Traits\RulesTrait;

use function strtolower;

/**
 * Rule
 */
class Rule
{
    use RulesTrait;

    protected array $arguments;

    protected Closure $callback;

    protected string|null $message = null;

    protected string|null $name = null;

    protected bool $skipEmpty = true;

    protected bool $skipNotSet = true;

    protected string|null $type = null;

    /**
     * New Rule constructor.
     *
     * @param Closure $callback The callback.
     * @param string|null $name The rule name.
     * @param array $arguments The callback arguments.
     * @param bool $skipEmpty Whether to skip validation for empty values.
     * @param bool $skipNotSet Whether to skip validation for unset values.
     */
    public function __construct(Closure $callback, string|null $name = null, array $arguments = [], bool $skipEmpty = true, bool $skipNotSet = true)
    {
        $this->callback = $callback;
        $this->name = $name;
        $this->arguments = $arguments;
        $this->skipEmpty = $skipEmpty;
        $this->skipNotSet = $skipNotSet;
    }

    /**
     * Invoke the rule.
     *
     * @param mixed $value The value to test.
     * @param array $data The validation data.
     * @param string $field The field name.
     * @return string|bool The error message, or TRUE if the validation was successful, otherwise FALSE.
     */
    public function __invoke(mixed $value, array $data, string $field): bool|string
    {
        return $this->callback->__invoke($value, $data, $field);
    }

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
     * Get the rule error message.
     *
     * @param string $field The field name.
     * @return string The error message.
     */
    public function getMessage(string $field): string
    {
        if ($this->message) {
            return $this->message;
        }

        if (!$this->name) {
            return 'invalid';
        }

        $langKey = 'Validation.'.$this->name;

        $arguments = $this->arguments;
        $arguments['field'] = $field;

        return Lang::get($langKey, $arguments) ?? 'invalid';
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
