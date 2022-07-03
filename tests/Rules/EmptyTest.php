<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait EmptyTest
{

    public function testEmpty(): void
    {
        $this->validator->add('test', Rule::empty());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testEmptyFalsey(): void
    {
        $this->validator->add('test', Rule::empty());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => '0'
            ])
        );
    }

    public function testEmptyMissing(): void
    {
        $this->validator->add('test', Rule::empty());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testEmptyEmpty(): void
    {
        $this->validator->add('test', Rule::empty());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
