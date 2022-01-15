# FyreValidation

**FyreValidation** is a free, validation library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Validators](#validators)
- [Rules](#rules)
- [Error Messages](#error-messages)



## Installation

**Using Composer**

```
composer require fyre/validation
```

In PHP:

```php
use Fyre\Validation\Rule;
use Fyre\Validation\Validator;
```


## Validators

```php
$validator = new Validator();
```

**Add**

Add a validation rule.

- `$field` is a string representing the field name.
- `$rule` is a *Closure* or a [*Rule*](#rules) representing the validation rule.
- `$options` is an array containing options for the validation rule.
    - `on` is a string representing the type of validation the rule applies to, and will default to *null*.
    - `message` is a string representing the error message for the rule, and will default to *null*.
    - `name` is a string representing the name of the validation rule, and will default to *null*.
    - `skipEmpty` is a boolean indicating whether the rule should be skipped if the value is empty, and will default to *true*.

```php
$validator->add($field, $rule, $options);
```

**Clear**

Clear all rules from the *Validator*.

```php
$validator->clear();
```

**Validate**

Perform validation and return any errors.

- `$data` is an array containing the data to validate.
- `$type` is a string representing the type of validation, and will default to *null*.

```php
$errors = $validator->validate($data, $type);
```


## Rules

**Alpha**

Create an "alpha" *Rule*.

```php
Rule::alpha();
```

**Alpha Numeric**

Create an "alpha-numeric" *Rule*.

```php
Rule::alphaNumeric();
```

**Ascii**

Create an "ASCII" *Rule*.

```php
Rule::ascii();
```

**Between**

Create a "between" *Rule*.

- `$min` is a number representing the minimum value (inclusive).
- `$max` is a number representing the maximum value (inclusive).

```php
Rule::between($min, $max);
```

**Boolean**

Create a "boolean" *Rule*.

```php
Rule::boolean();
```

**Decimal**

Create a "decimal" *Rule*.

```php
Rule::decimal();
```

**Differs**

Create a "differs" *Rule*.

- `$field` is a string representing the other field to compare against.

```php
Rule::differs($field);
```

**Email**

Create an "email" *Rule*.

```php
Rule::email();
```

**Equals**

Create an "equals" *Rule*.

- `$value` is the value to compare against.

```php
Rule::equals($value);
```

**Exact Length**

Create an "exact length" *Rule*.

- `$length` is a number representing the length.

```php
Rule::exactLength($length);
```

**Greater Than**

Create a "greater than" *Rule*.

- `$min` is the minimum value.

```php
Rule::greaterThan($min);
```

**Greater Than Or Equals**

Create a "greater than or equals" *Rule*.

- `$min` is the minimum value.

```php
Rule::greaterThanOrEquals($min);
```

**In**

Create an "in" *Rule*.

- `$values` is an array containing the values to compare against.

```php
Rule::in($values);
```

**Integer**

Create an "integer" *Rule*.

```php
Rule::integer();
```

**Ip**

Create an "IP" *Rule*.

```php
Rule::ip();
```

**Ipv4**

Create an "IPv4" *Rule*.

```php
Rule::ipv4();
```

**Ipv6**

Create an "IPv6" *Rule*.

```php
Rule::ipv6();
```

**Less Than**

Create a "less than" *Rule*.

- `$max` is the maximum value.

```php
Rule::lessThan($max);
```

**Less Than Or Equals**

Create a "less than or equals" *Rule*.

- `$max` is the maximum value.

```php
Rule::lessThanOrEquals($max);
```

**Matches**

Create a "matches" *Rule*.

- `$field` is a string representing the other field to compare against.

```php
Rule::matches($field);
```

**Max Length**

Create a "maximum length" *Rule*.

- `$length` is a number representing the maximum length.

```php
Rule::maxLength($length);
```

**Min Length**

Create a "minimum length" *Rule*.

- `$length` is a number representing the minimum length.

```php
Rule::minLength($length);
```

**Natural Number**

Create a "natural number" *Rule*.

```php
Rule::naturalNumber();
```

**Regex**

Create a "regular expression" *Rule*.

- `$regex` is a string representing the regular expression.

```php
Rule::regex($regex);
```

**Required**

Create a "required" *Rule*.

```php
Rule::required();
```

**Url**

Create a "URL" *Rule*.

```php
Rule::url();
```


## Error Messages

Custom error messages can be used by supplying the `message` property of the `$options` array to the *Validator* `add` method.

```php
$validator->add('field', Rule::required(), [
    'message' => 'The field is required.'
]);
```

Alternatively, for custom validation callbacks, a string can be returned and that will be used as the error messages.

```php
$validator->add('field', function($value) {
    if ($value) {
        return true;
    }

    return 'The field is required.';
});
```

If a custom error message is not supplied, the rule name will be used to retrieve a [*Lang*](https://github.com/elusivecodes/FyreLang) value. The field placeholder can be used for the field name, and any arguments supplied to the rule will be available as numeric placeholders.

```php
// language/en/Validation.php

return [
    'required' => 'The {field} is required.'
];
```

If no error message is available, the error message will simply be set to "*invalid*".