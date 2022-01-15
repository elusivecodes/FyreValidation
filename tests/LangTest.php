<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Lang\Lang,
    Fyre\Validation\Rule,
    Fyre\Validation\Validator,
    PHPUnit\Framework\TestCase;

final class LangTest extends TestCase
{

    protected Validator $validator;

    public function testAlphaError(): void
    {
        $this->validator->add('field', Rule::alpha());

        $this->assertSame(
            [
                'field' => ['The field must only contain alphabetical characters.']
            ],
            $this->validator->validate([
                'field' => 'invalid123'
            ])
        );
    }

    public function testAlphaNumericError(): void
    {
        $this->validator->add('field', Rule::alphaNumeric());

        $this->assertSame(
            [
                'field' => ['The field must only contain alpha-numeric characters.']
            ],
            $this->validator->validate([
                'field' => 'invalid123!'
            ])
        );
    }

    public function testAsciiError(): void
    {
        $this->validator->add('field', Rule::ascii());

        $this->assertSame(
            [
                'field' => ['The field must only contain ASCII characters.']
            ],
            $this->validator->validate([
                'field' => 'invalid♫'
            ])
        );
    }

    public function testBetweenError(): void
    {
        $this->validator->add('field', Rule::between(5, 10));

        $this->assertSame(
            [
                'field' => [
                    'The field must be between 5 and 10.'
                ]
            ],
            $this->validator->validate([
                'field' => '1'
            ])
        );
    }

    public function testBooleanError(): void
    {
        $this->validator->add('field', Rule::boolean());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a boolean value.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testDecimalError(): void
    {
        $this->validator->add('field', Rule::decimal());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a decimal value.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testDiffersError(): void
    {
        $this->validator->add('field', Rule::differs('other'));

        $this->assertSame(
            [
                'field' => [
                    'The field must have a different value than other.'
                ]
            ],
            $this->validator->validate([
                'field' => 'test',
                'other' => 'test'
            ])
        );
    }

    public function testEmailError(): void
    {
        $this->validator->add('field', Rule::email());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a valid email address.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testEqualsError(): void
    {
        $this->validator->add('field', Rule::equals('2'));

        $this->assertSame(
            [
                'field' => [
                    'The field must be equal to 2.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testExactLengthError(): void
    {
        $this->validator->add('field', Rule::exactLength(3));

        $this->assertSame(
            [
                'field' => [
                    'The field length must be exactly 3.'
                ]
            ],
            $this->validator->validate([
                'field' => 'test'
            ])
        );
    }

    public function testGreaterThanError(): void
    {
        $this->validator->add('field', Rule::greaterThan(2));

        $this->assertSame(
            [
                'field' => [
                    'The field must be greater than 2.'
                ]
            ],
            $this->validator->validate([
                'field' => 1
            ])
        );
    }

    public function testGreaterThanOrEqualsError(): void
    {
        $this->validator->add('field', Rule::greaterThanOrEquals(2));

        $this->assertSame(
            [
                'field' => [
                    'The field must be greater than or equal to 2.'
                ]
            ],
            $this->validator->validate([
                'field' => 1
            ])
        );
    }

    public function testInError(): void
    {
        $this->validator->add('field', Rule::in(['test', 'other']));

        $this->assertSame(
            [
                'field' => [
                    'The field must be one of the values: test, other'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testIntegerError(): void
    {
        $this->validator->add('field', Rule::integer());

        $this->assertSame(
            [
                'field' => [
                    'The field must be an integer value.'
                ]
            ],
            $this->validator->validate([
                'field' => '123.456'
            ])
        );
    }

    public function testIpError(): void
    {
        $this->validator->add('field', Rule::ip());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a valid IP address.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testIpv4Error(): void
    {
        $this->validator->add('field', Rule::ipv4());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a valid IPv4 address.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testIpv6Error(): void
    {
        $this->validator->add('field', Rule::ipv6());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a valid IPv6 address.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testLessThanError(): void
    {
        $this->validator->add('field', Rule::lessThan(2));

        $this->assertSame(
            [
                'field' => [
                    'The field must be less than 2.'
                ]
            ],
            $this->validator->validate([
                'field' => 3
            ])
        );
    }

    public function testLessThanOrEqualsError(): void
    {
        $this->validator->add('field', Rule::lessThanOrEquals(2));

        $this->assertSame(
            [
                'field' => [
                    'The field must be less than or equal to 2.'
                ]
            ],
            $this->validator->validate([
                'field' => 3
            ])
        );
    }

    public function testMatchesError(): void
    {
        $this->validator->add('field', Rule::matches('other'));

        $this->assertSame(
            [
                'field' => [
                    'The field must have the same value as other.'
                ]
            ],
            $this->validator->validate([
                'field' => 'test',
                'other' => 'different'
            ])
        );
    }

    public function testMaxLengthError(): void
    {
        $this->validator->add('field', Rule::maxLength(3));

        $this->assertSame(
            [
                'field' => [
                    'The field length must be at most 3.'
                ]
            ],
            $this->validator->validate([
                'field' => 'test'
            ])
        );
    }

    public function testMinLengthError(): void
    {
        $this->validator->add('field', Rule::minLength(3));

        $this->assertSame(
            [
                'field' => [
                    'The field length must be at least 3.'
                ]
            ],
            $this->validator->validate([
                'field' => 'a'
            ])
        );
    }

    public function testNaturalNumberError(): void
    {
        $this->validator->add('field', Rule::naturalNumber());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a natural number.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testRegexError(): void
    {
        $this->validator->add('field', Rule::regex('/test/'));

        $this->assertSame(
            [
                'field' => [
                    'The field must match the regular expression /test/.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public function testRequiredError(): void
    {
        $this->validator->add('field', Rule::required());

        $this->assertSame(
            [
                'field' => [
                    'The field is required.'
                ]
            ],
            $this->validator->validate([])
        );
    }

    public function testUrlError(): void
    {
        $this->validator->add('field', Rule::url());

        $this->assertSame(
            [
                'field' => [
                    'The field must be a valid URL.'
                ]
            ],
            $this->validator->validate([
                'field' => 'invalid'
            ])
        );
    }

    public static function setUpBeforeClass(): void
    {
        Lang::clear();
        Lang::addPath('lang');
    }

    protected function setUp(): void
    {
        $this->validator = new Validator;
    }

}
