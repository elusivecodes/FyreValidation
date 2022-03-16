<?php
declare(strict_types=1);

namespace Fyre\Validation;

use
    Closure,
    Fyre\Lang\Lang,
    Fyre\Validation\Traits\RulesTrait;

use function
    strtolower;

/**
 * Rule
 */
class Rule
{

    protected Closure $callback;

    protected string|null $name = null;

    protected array $arguments;

    protected bool $skipEmpty = false;

    protected string|null $type = null;

    protected string|null $message = null;

    use
        RulesTrait;

    /**
     * New Rule constructor.
     * @param Closure $callback The callback.
     * @param string|null $name The rule name.
     * @param array $arguments The callback arguments.
     * @param bool $skipEmpty Whether to skip the rule for empty values.
     */
    public function __construct(Closure $callback, string|null $name = null, array $arguments = [], bool $skipEmpty = true)
    {
        $this->callback = $callback;
        $this->name = $name;
        $this->arguments = $arguments;
        $this->skipEmpty = $skipEmpty;
    }

    /**
     * Invoke the rule.
     * @param mixed $value The value to test.
     * @param array $data The validation data.
     */
    public function __invoke(mixed $value, array $data)
    {
        if ($this->skipEmpty && ($value === null || $value === '' || $value === [])) {
            return true;
        }

        return $this->callback->__invoke($value, $data);
    }

    /**
     * Check the type of rule.
     * @param string $type The type to test.
     * @return bool TRUE if the types match, otherwise FALSE.
     */
    public function checkType(string|null $type = null): bool
    {
        return !$type || !$this->type || strtolower($type) === $this->type;
    }

    /**
     * Get the rule error message.
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
     * Set the rule error message.
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
     * @param string $type The rule type.
     * @return Rule The Rule.
     */
    public function setType(string $type): static
    {
        $this->type = strtolower($type);

        return $this;
    }

}
