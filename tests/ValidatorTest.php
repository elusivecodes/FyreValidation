<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Container\Container;
use Fyre\DB\TypeParser;
use Fyre\Lang\Lang;
use Fyre\Validation\Rule;
use Fyre\Validation\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    protected Validator $validator;

    public function testCallback(): void
    {
        $this->validator->add('test', function($value) {
            return $value === 'test';
        });

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test',
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
                'test' => 'test',
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
                'test' => ['error'],
            ],
            $this->validator->validate([
                'test' => 'invalid',
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
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => 'invalid',
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
                'test' => ['error'],
            ],
            $this->validator->validate([
                'test' => 'test',
            ])
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

    public function testMultipleErrors(): void
    {
        $this->validator->add('test', Rule::naturalNumber(), ['message' => 'natural number']);
        $this->validator->add('test', Rule::greaterThan(1), ['message' => 'greater than 1']);

        $this->assertSame(
            [
                'test' => [
                    'natural number',
                    'greater than 1',
                ],
            ],
            $this->validator->validate([
                'test' => 0.5,
            ])
        );
    }

    public function testMultipleErrorsUnique(): void
    {
        $this->validator->add('test', Rule::naturalNumber());
        $this->validator->add('test', Rule::greaterThan(1));

        $this->assertSame(
            [
                'test' => [
                    'The test must be a natural number.',
                    'The test must be greater than 1.'
                ],
            ],
            $this->validator->validate([
                'test' => 0.5,
            ])
        );
    }

    public function testMultipleFields(): void
    {
        $this->validator->add('test1', Rule::required());
        $this->validator->add('test2', Rule::required());

        $this->assertSame(
            [
                'test1' => ['The test1 is required.'],
                'test2' => ['The test2 is required.'],
            ],
            $this->validator->validate([])
        );
    }

    public function testOn(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['on' => 'create']);

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => 'test',
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
                'test' => 'test',
            ], 'update')
        );
    }

    public function testRemove(): void
    {
        $this->validator->add('test', Rule::naturalNumber(), ['message' => 'natural number']);
        $this->validator->add('test', Rule::greaterThan(1), ['message' => 'greater than 1']);

        $this->assertTrue(
            $this->validator->remove('test')
        );

        $this->assertEmpty(
            $this->validator->getFieldRules('test')
        );
    }

    public function testRemoveInvalid(): void
    {
        $this->assertFalse(
            $this->validator->remove('test', 'greaterThan')
        );
    }

    public function testRemoveRule(): void
    {
        $this->validator->add('test', Rule::naturalNumber(), ['message' => 'natural number']);
        $this->validator->add('test', Rule::greaterThan(1), ['message' => 'greater than 1']);

        $this->assertTrue(
            $this->validator->remove('test', 'greaterThan')
        );

        $rules = $this->validator->getFieldRules('test');

        $this->assertCount(
            1,
            $rules
        );
    }

    public function testRemoveRuleInvalid(): void
    {
        $this->validator->add('test', Rule::naturalNumber(), ['message' => 'natural number']);

        $this->assertFalse(
            $this->validator->remove('test', 'greaterThan')
        );
    }

    public function testSkipEmpty(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['skipEmpty' => false]);

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => '',
            ])
        );
    }

    public function testSkipNotSet(): void
    {
        $this->validator->add('test', function($value) {
            return false;
        }, ['skipEmpty' => false, 'skipNotSet' => false]);

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([])
        );
    }

    protected function setUp(): void
    {
        $container = new Container();
        $container->singleton(TypeParser::class);
        $container->singleton(Lang::class);

        $this->validator = $container->use(Validator::class);
    }
}
