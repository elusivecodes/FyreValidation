<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait AlphaNumericTestTrait
{
    public function testAlphaNumeric(): void
    {
        $this->validator->add('test', Rule::alphaNumeric());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test123'
            ])
        );
    }

    public function testAlphaNumericEmpty(): void
    {
        $this->validator->add('test', Rule::alphaNumeric());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

    public function testAlphaNumericInvalid(): void
    {
        $this->validator->add('test', Rule::alphaNumeric());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid123!'
            ])
        );
    }

    public function testAlphaNumericMissing(): void
    {
        $this->validator->add('test', Rule::alphaNumeric());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }
}
