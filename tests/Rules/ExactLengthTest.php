<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait ExactLengthTest
{

    public function testExactLength(): void
    {
        $this->validator->add('test', Rule::exactLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '123'
            ])
        );
    }

    public function testExactLengthInvalid(): void
    {
        $this->validator->add('test', Rule::exactLength(3));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testExactLengthMissing(): void
    {
        $this->validator->add('test', Rule::exactLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testExactLengthEmpty(): void
    {
        $this->validator->add('test', Rule::exactLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
