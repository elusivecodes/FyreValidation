<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait MinLengthTest
{

    public function testMinLength(): void
    {
        $this->validator->add('test', Rule::minLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testMinLengthExact(): void
    {
        $this->validator->add('test', Rule::minLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '123'
            ])
        );
    }

    public function testMinLengthInvalid(): void
    {
        $this->validator->add('test', Rule::minLength(3));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'a'
            ])
        );
    }

    public function testMinLengthMissing(): void
    {
        $this->validator->add('test', Rule::minLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testMinLengthEmpty(): void
    {
        $this->validator->add('test', Rule::minLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
