<?php
declare(strict_types=1);

namespace Fyre\Validation;

use
    Closure;

use function
    array_merge,
    array_unique;

/**
 * Validator
 */
class Validator
{

    protected array $fields = [];

    /**
     * Add a validation rule.
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
                $options['skipEmpty'] ?? true
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
     * @return Validator The Validator.
     */
    public function clear(): static
    {
        $this->fields = [];
    }

    /**
     * Perform validation and return any errors.
     * @param array $data The data to validate.
     * @param string|null $type The type of validation to perform.
     * @return array The validation errors.
     */
    public function validate(array $data, string|null $type = null): array
    {
        $errors = [];

        foreach ($this->fields AS $field => $rules) {
            $value = $data[$field] ?? null;

            $fieldErrors = [];
            foreach ($rules AS $rule) {
                if (!$rule->checkType($type)) {
                    continue;
                }

                $result = $rule($value, $data);

                if ($result === true) {
                    continue;
                }

                $fieldErrors[] = $result ?: $rule->getMessage($field);
            }

            if ($fieldErrors !== []) {
                $errors[$field] = array_unique($fieldErrors);
            }
        }

        return $errors;
    }

}
