<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait GreaterThanOrEqualsTestTrait
{
    public function testGreaterThanOrEquals(): void
    {
        $this->validator->add('test', Rule::greaterThanOrEquals(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 3
            ])
        );
    }

    public function testGreaterThanOrEqualsBelow(): void
    {
        $this->validator->add('test', Rule::greaterThanOrEquals(2));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 1
            ])
        );
    }

    public function testGreaterThanOrEqualsEmpty(): void
    {
        $this->validator->add('test', Rule::greaterThanOrEquals(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

    public function testGreaterThanOrEqualsEquals(): void
    {
        $this->validator->add('test', Rule::greaterThanOrEquals(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 2
            ])
        );
    }

    public function testGreaterThanOrEqualsMissing(): void
    {
        $this->validator->add('test', Rule::greaterThanOrEquals(2));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }
}
