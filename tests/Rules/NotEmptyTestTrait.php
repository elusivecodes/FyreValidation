<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait NotEmptyTestTrait
{

    public function testNotEmpty(): void
    {
        $this->validator->add('test', Rule::notEmpty());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testNotEmptyFalsey(): void
    {
        $this->validator->add('test', Rule::notEmpty());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '0'
            ])
        );
    }

    public function testNotEmptyMissing(): void
    {
        $this->validator->add('test', Rule::notEmpty());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testNotEmptyEmpty(): void
    {
        $this->validator->add('test', Rule::notEmpty());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
