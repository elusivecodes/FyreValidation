<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait RegexTestTrait
{
    public function testRegex(): void
    {
        $this->validator->add('test', Rule::regex('/test/'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test'
            ])
        );
    }

    public function testRegexEmpty(): void
    {
        $this->validator->add('test', Rule::regex('/test/'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

    public function testRegexInvalid(): void
    {
        $this->validator->add('test', Rule::regex('/test/'));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testRegexMissing(): void
    {
        $this->validator->add('test', Rule::regex('/test/'));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }
}
