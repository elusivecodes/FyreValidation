<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait InTestTrait
{

    public function TestIn(): void
    {
        $this->validator->add('test', Rule::in(['test', 'other']));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function TestInInvalid(): void
    {
        $this->validator->add('test', Rule::in(['test', 'other']));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function TestInMissing(): void
    {
        $this->validator->add('test', Rule::in(['test', 'other']));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function TestInEmpty(): void
    {
        $this->validator->add('test', Rule::in(['test', 'other']));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
