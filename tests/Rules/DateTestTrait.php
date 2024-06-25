<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\DateTime\DateTime;
use Fyre\Validation\Rule;

trait DateTestTrait
{
    public function testDate(): void
    {
        $this->validator->add('test', Rule::date());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => DateTime::now(),
            ])
        );
    }

    public function testDateEmpty(): void
    {
        $this->validator->add('test', Rule::date());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
            ])
        );
    }

    public function testDateInvalid(): void
    {
        $this->validator->add('test', Rule::date());

        $this->assertSame(
            [
                'test' => ['invalid'],
            ],
            $this->validator->validate([
                'test' => 'invalid',
            ])
        );
    }

    public function testDateMissing(): void
    {
        $this->validator->add('test', Rule::date());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testDateString(): void
    {
        $this->validator->add('test', Rule::date());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '2022-01-01',
            ])
        );
    }
}
