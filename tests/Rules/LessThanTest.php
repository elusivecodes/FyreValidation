<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait LessThanTest
{

    public function testLessThan(): void
    {
        $this->validator->add('test', Rule::lessThan(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 1
            ])
        );
    }

    public function testLessThanEquals(): void
    {
        $this->validator->add('test', Rule::lessThan(2));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 2
            ])
        );
    }

    public function testLessThanAbove(): void
    {
        $this->validator->add('test', Rule::lessThan(2));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 3
            ])
        );
    }

    public function testLessThanMissing(): void
    {
        $this->validator->add('test', Rule::lessThan(2));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testLessThanEmpty(): void
    {
        $this->validator->add('test', Rule::lessThan(2));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
