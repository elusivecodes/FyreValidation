<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait RequiredTestTrait
{

    public function testRequired(): void
    {
        $this->validator->add('test', Rule::required());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testRequiredFalsey(): void
    {
        $this->validator->add('test', Rule::required());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '0'
            ])
        );
    }

    public function testRequiredMissing(): void
    {
        $this->validator->add('test', Rule::required());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([])
        );
    }

    public function testRequiredEmpty(): void
    {
        $this->validator->add('test', Rule::required());

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
