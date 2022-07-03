<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\DateTime\DateTime,
    Fyre\Validation\Rule;

trait TimeTest
{

    public function testTime(): void
    {
        $this->validator->add('test', Rule::time());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => DateTime::now()
            ])
        );
    }

    public function testTimeString(): void
    {
        $this->validator->add('test', Rule::time());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '00:00:00'
            ])
        );
    }

    public function testTimeInvalid(): void
    {
        $this->validator->add('test', Rule::time());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testTimeMissing(): void
    {
        $this->validator->add('test', Rule::time());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testTimeEmpty(): void
    {
        $this->validator->add('test', Rule::time());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
