<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait MaxLengthTestTrait
{

    public function testMaxLength(): void
    {
        $this->validator->add('test', Rule::maxLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'a'
            ])
        );
    }

    public function testMaxLengthExact(): void
    {
        $this->validator->add('test', Rule::maxLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '123'
            ])
        );
    }

    public function testMaxLengthInvalid(): void
    {
        $this->validator->add('test', Rule::maxLength(3));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testMaxLengthMissing(): void
    {
        $this->validator->add('test', Rule::maxLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testMaxLengthEmpty(): void
    {
        $this->validator->add('test', Rule::maxLength(3));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
