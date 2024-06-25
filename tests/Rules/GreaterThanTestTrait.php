<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait GreaterThanTestTrait
{
    public function testGreaterThan(): void
    {
        $this->validator->add('test', Rule::greaterThan(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 3,
            ])
        );
    }

    public function testGreaterThanBelow(): void
    {
        $this->validator->add('test', Rule::greaterThan(2));

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => 1,
            ])
        );
    }

    public function testGreaterThanEmpty(): void
    {
        $this->validator->add('test', Rule::greaterThan(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
            ])
        );
    }

    public function testGreaterThanEquals(): void
    {
        $this->validator->add('test', Rule::greaterThan(2));

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => 2,
            ])
        );
    }

    public function testGreaterThanMissing(): void
    {
        $this->validator->add('test', Rule::greaterThan(2));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }
}
