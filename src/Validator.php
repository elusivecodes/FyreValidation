<?php
declare(strict_types=1);

namespace Fyre\Validation;

use Closure;
use Fyre\Container\Container;
use Fyre\DB\TypeParser;
use Fyre\Lang\Lang;

use function array_key_exists;
use function array_unique;

/**
 * Validator
 */
class Validator
{
    protected Container $container;

    protected array $fields = [];

    protected Lang|null $lang = null;

    protected TypeParser $typeParser;

    /**
     * New Validator constructor.
     *
     * @param Container $container The Container.
     * @param Lang $lang The Lang.
     */
    public function __construct(Container $container, TypeParser $typeParser, Lang $lang)
    {
        $this->container = $container;
        $this->lang = $lang;
        $this->typeParser = $typeParser;

        $this->lang->addPath(__DIR__.'/../lang');
    }

    /**
     * Add a validation rule.
     *
     * @param string $field The field name.
     * @param Closure|Rule $rule The Rule.
     * @param array $options Options for the rule.
     * @return Validator The Validator.
     */
    public function add(string $field, Closure|Rule $rule, array $options = []): static
    {
        $options['on'] ??= null;
        $options['message'] ??= null;

        if ($rule instanceof Closure) {
            $rule = new Rule(
                $rule,
                $options['name'] ?? null,
                $options['arguments'] ?? [],
                $options['skipEmpty'] ?? true,
                $options['skipNotSet'] ?? true
            );
        }

        if ($options['on']) {
            $rule->setType($options['on']);
        }

        if ($options['message']) {
            $rule->setMessage($options['message']);
        }

        $this->fields[$field] ??= [];
        $this->fields[$field][] = $rule;

        return $this;
    }

    /**
     * Clear all rules from the Validator.
     *
     * @return Validator The Validator.
     */
    public function clear(): void
    {
        $this->fields = [];
    }

    /**
     * Get the rules for a field.
     *
     * @param string $field The field name.
     * @return array The rules.
     */
    public function getFieldRules(string $field): array
    {
        return $this->fields[$field] ?? [];
    }

    /**
     * Remove a validation rule.
     *
     * @param string $field The field name.
     * @param string|null $name The rule name.
     * @return bool TRUE if the rule was removed, otherwise FALSE.
     */
    public function remove(string $field, string|null $name = null): bool
    {
        if (!array_key_exists($field, $this->fields)) {
            return false;
        }

        if ($name === null) {
            unset($this->fields[$field]);

            return true;
        }

        $hasRule = false;
        $newRules = [];

        foreach ($this->fields[$field] as $rule) {
            if ($rule->getName() === $name) {
                $hasRule |= true;

                continue;
            }

            $newRules[] = $rule;
        }

        if (!$hasRule) {
            return false;
        }

        if ($newRules === []) {
            unset($this->fields[$field]);
        } else {
            $this->fields[$field] = $newRules;
        }

        return true;
    }

    /**
     * Perform validation and return any errors.
     *
     * @param array $data The data to validate.
     * @param string|null $type The type of validation to perform.
     * @return array The validation errors.
     */
    public function validate(array $data, string|null $type = null): array
    {
        $errors = [];

        foreach ($this->fields as $field => $rules) {
            $value = $data[$field] ?? null;

            $hasField = array_key_exists($field, $data);
            $hasValue = $value !== null && $value !== '' && $value !== [];

            $fieldErrors = [];
            foreach ($rules as $rule) {
                if (!$rule->checkType($type)) {
                    continue;
                }

                if (!$hasField && $rule->skipNotSet()) {
                    continue;
                }

                if (!$hasValue && $rule->skipEmpty()) {
                    continue;
                }

                $result = Closure::bind($rule->getCallback(), $this, $this)($value, $data, $field);

                if ($result === true) {
                    continue;
                }

                if (!$result) {
                    $result = $rule->getMessage();
                }

                if (!$result) {
                    $name = $rule->getName();

                    if ($name) {
                        $arguments = $rule->getArguments();
                        $arguments['field'] = $field;

                        $result = $this->lang->get('Validation.'.$name, $arguments);
                    }
                }

                if (!$result) {
                    $result = 'invalid';
                }

                $fieldErrors[] = $result;
            }

            if ($fieldErrors !== []) {
                $errors[$field] = array_unique($fieldErrors);
            }
        }

        return $errors;
    }
}
