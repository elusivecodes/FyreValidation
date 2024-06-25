<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait AlphaTestTrait
{
    public function testAlpha(): void
    {
        $this->validator->add('test', Rule::alpha());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test',
            ])
        );
    }

    public function testAlphaEmpty(): void
    {
        $this->validator->add('test', Rule::alpha());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
            ])
        );
    }

    public function testAlphaInvalid(): void
    {
        $this->validator->add('test', Rule::alpha());

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => 'invalid123',
            ])
        );
    }

    public function testAlphaMissing(): void
    {
        $this->validator->add('test', Rule::alpha());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }
}
