<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Validation\Rule;

trait UrlTestTrait
{

    public function testUrl(): void
    {
        $this->validator->add('test', Rule::url());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'https://test.com/'
            ])
        );
    }

    public function testUrlInvalid(): void
    {
        $this->validator->add('test', Rule::url());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testUrlMissing(): void
    {
        $this->validator->add('test', Rule::url());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testUrlEmpty(): void
    {
        $this->validator->add('test', Rule::url());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
