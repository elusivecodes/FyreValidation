<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait NaturalNumberTest
{

    public function testNaturalNumber(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '123'
            ])
        );
    }

    public function testNaturalNumberZero(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '0'
            ])
        );
    }

    public function testNaturalNumberNegative(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => '-123'
            ])
        );
    }

    public function testNaturalNumberDecimal(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => '123.456'
            ])
        );
    }

    public function testNaturalNumberInvalid(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testNaturalNumberMissing(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testNaturalNumberEmpty(): void
    {
        $this->validator->add('test', Rule::naturalNumber());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
