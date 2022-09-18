<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Lang\Lang,
    Fyre\Validation\Rule,
    Fyre\Validation\Validator,
    PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{

    protected Validator $validator;

    public function testMultipleFields(): void
    {
        $this->validator->add('test1', Rule::required());
        $this->validator->add('test2', Rule::required());

        $this->assertSame(
            [
                'test1' => ['invalid'],
                'test2' => ['invalid']
            ],
            $this->validator->validate([])
        );
    }

    public function testMultipleErrors(): void
    {
        $this->validator->add('test', Rule::naturalNumber(), ['message' => 'natural number']);
        $this->validator->add('test', Rule::greaterThan(1), ['message' => 'greater than 1']);

        $this->assertSame(
            [
                'test' => [
                    'natural number',
                    'greater than 1'
                ]
            ],
            $this->validator->validate([
                'test' => 0.5
            ])
        );
    }

    public function testMultipleErrorsUnique(): void
    {
        $this->validator->add('test', Rule::naturalNumber());
        $this->validator->add('test', Rule::greaterThan(1));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 0.5
            ])
        );
    }

    public function testCallback(): void
    {
        $this->validator->add('test', function($value) {
            return $value === 'test';
        });

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testCallbackData(): void
    {
        $this->validator->add('test', function($value, array $data) {
            return $data['test'] === 'test';
        });

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testCallbackInvalid(): void
    {
        $this->validator->add('test', function($value) {
            return $value === 'test';
        });

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testCallbackErrorMessage(): void
    {
        $this->validator->add('test', function($value) {
            return 'error';
        });

        $this->assertSame(
            [
                'test' => ['error']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testErrorMessage(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['message' => 'error']);

        $this->assertSame(
            [
                'test' => ['error']
            ],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testOn(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['on' => 'create']);

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'test'
            ], 'create')
        );
    }

    public function testOnSkip(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['on' => 'create']);

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ], 'update')
        );
    }

    public function testSkipEmpty(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['skipEmpty' => false]);

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([])
        );
    }

    public function testGetFieldRules(): void
    {
        $this->validator->add('test', Rule::naturalNumber(), ['message' => 'natural number']);
        $this->validator->add('test', Rule::greaterThan(1), ['message' => 'greater than 1']);

        $rules = $this->validator->getFieldRules('test');

        $this->assertCount(
            2,
            $rules
        );

        $this->assertInstanceOf(
            Rule::class,
            $rules[0]
        );

        $this->assertInstanceOf(
            Rule::class,
            $rules[1]
        );
    }

    public static function setUpBeforeClass(): void
    {
        Lang::clear();
    }

    protected function setUp(): void
    {
        $this->validator = new Validator;
    }

}
