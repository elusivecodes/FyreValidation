<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\DateTime\DateTime,
    Fyre\Validation\Rule;

trait DateTimeTest
{

    public function testDateTime(): void
    {
        $this->validator->add('test', Rule::dateTime());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => DateTime::now()
            ])
        );
    }

    public function testDateTimeString(): void
    {
        $this->validator->add('test', Rule::dateTime());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '2022-01-01 00:00:00'
            ])
        );
    }

    public function testDateTimeInvalid(): void
    {
        $this->validator->add('test', Rule::dateTime());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testDateTimeMissing(): void
    {
        $this->validator->add('test', Rule::dateTime());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testDateTimeEmpty(): void
    {
        $this->validator->add('test', Rule::dateTime());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
