<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait EmailTestTrait
{

    public function testEmail(): void
    {
        $this->validator->add('test', Rule::email());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test@test.com'
            ])
        );
    }

    public function testEmailInvalid(): void
    {
        $this->validator->add('test', Rule::email());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testEmailMissing(): void
    {
        $this->validator->add('test', Rule::email());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testEmailEmpty(): void
    {
        $this->validator->add('test', Rule::email());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
