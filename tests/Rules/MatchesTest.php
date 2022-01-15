<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait MatchesTest
{

    public function testMatches(): void
    {
        $this->validator->add('test', Rule::matches('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test',
                'other' => 'test'
            ])
        );
    }

    public function testMatchesDifferent(): void
    {
        $this->validator->add('test', Rule::matches('other'));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'test',
                'other' => 'different'
            ])
        );
    }

    public function testMatchesMissing(): void
    {
        $this->validator->add('test', Rule::matches('other'));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testMatchesEmpty(): void
    {
        $this->validator->add('test', Rule::matches('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
                'other' => 'test'
            ])
        );
    }

    public function testMatchesOtherEmpty(): void
    {
        $this->validator->add('test', Rule::matches('other'));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'test',
                'other' => ''
            ])
        );
    }

    public function testMatchesBothEmpty(): void
    {
        $this->validator->add('test', Rule::matches('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
                'other' => ''
            ])
        );
    }

}
