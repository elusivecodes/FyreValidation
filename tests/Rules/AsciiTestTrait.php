<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait AsciiTestTrait
{

    public function testAscii(): void
    {
        $this->validator->add('test', Rule::ascii());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test123!'
            ])
        );
    }

    public function testAsciiInvalid(): void
    {
        $this->validator->add('test', Rule::ascii());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid♫'
            ])
        );
    }

    public function testAsciiMissing(): void
    {
        $this->validator->add('test', Rule::ascii());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testAsciiEmpty(): void
    {
        $this->validator->add('test', Rule::ascii());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
