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

Add a Rule to the validator.

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

Clear all rules from the Validator.

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

Validates if the value contains only alphabetical characters.

```php
$validator->add('field', Rule::alpha());
```

**Alpha Numeric**

Validates if the value contains only alpha-numeric characters.

```php
$validator->add('field', Rule::alphaNumeric());
```

**Ascii**

Validates if the value contains only ASCII characters.

```php
$validator->add('field', Rule::ascii());
```

**Between**

Validates if the value is between a minimum and a maximum (inclusive).

- `$min` is a number representing the minimum value.
- `$max` is a number representing the maximum value.

```php
$validator->add('field', Rule::between($min, $max));
```

**Boolean**

Validates if the value can be converted to a boolean.

```php
$validator->add('field', Rule::boolean());
```

**Decimal**

Validates if the value is a decimal number.

```php
$validator->add('field', Rule::decimal());
```

**Differs**

Validates if the value is different to another field value.

- `$field` is a string representing the other field to compare against.

```php
$validator->add('field', Rule::differs($field));
```

**Email**

Validates if the value is an email address.

```php
$validator->add('field', Rule::email());
```

**Equals**

Validates if the value is equal to the supplied value.

- `$value` is the value to compare against.

```php
$validator->add('field', Rule::equals($value));
```

**Exact Length**

Validates if the value length is exactly equal to the supplied value.

- `$length` is a number representing the length.

```php
$validator->add('field', Rule::exactLength($length));
```

**Greater Than**

Validates if the value is greater than the supplied value.

- `$min` is the minimum value.

```php
$validator->add('field', Rule::greaterThan($min));
```

**Greater Than Or Equals**

Validates if the value is greater than or equal to the supplied value.

- `$min` is the minimum value.

```php
$validator->add('field', Rule::greaterThanOrEquals($min));
```

**In**

Validates if the value is equal to one of the supplied values.

- `$values` is an array containing the values to compare against.

```php
$validator->add('field', Rule::in($values));
```

**Integer**

Validates if the value is an integer.

```php
$validator->add('field', Rule::integer());
```

**Ip**

Validates if the value is an IP address.

```php
$validator->add('field', Rule::ip());
```

**Ipv4**

Validates if the value is an IPv4 address.

```php
$validator->add('field', Rule::ipv4());
```

**Ipv6**

Validates if the value is an IPv6 address.

```php
$validator->add('field', Rule::ipv6());
```

**Less Than**

Validates if the value is less than the supplied value.

- `$max` is the maximum value.

```php
$validator->add('field', Rule::lessThan($max));
```

**Less Than Or Equals**

Validates if the value is less than or equal to the supplied value.

- `$max` is the maximum value.

```php
$validator->add('field', Rule::lessThanOrEquals($max));
```

**Matches**

Validates if the value is equal to another field value.

- `$field` is a string representing the other field to compare against.

```php
$validator->add('field', Rule::matches($field));
```

**Max Length**

Validates if the value length is less than the supplied value.

- `$length` is a number representing the maximum length.

```php
$validator->add('field', Rule::maxLength($length));
```

**Min Length**

Validates if the value length is greater than the supplied value.

- `$length` is a number representing the minimum length.

```php
$validator->add('field', Rule::minLength($length));
```

**Natural Number**

Validates if hte value is a natural number.

```php
$validator->add('field', Rule::naturalNumber());
```

**Regex**

Validates if the value matches a regular expression.

- `$regex` is a string representing the regular expression.

```php
$validator->add('field', Rule::regex($regex));
```

**Required**

Validates if the value is not empty.

```php
$validator->add('field', Rule::required());
```

**Url**

Validates if the value is a valid URL.

```php
$validator->add('field', Rule::url());
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