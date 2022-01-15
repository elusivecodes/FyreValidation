<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait DiffersTest
{

    public function testDiffers(): void
    {
        $this->validator->add('test', Rule::differs('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test',
                'other' => 'different'
            ])
        );
    }

    public function testDiffersSame(): void
    {
        $this->validator->add('test', Rule::differs('other'));

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'test',
                'other' => 'test'
            ])
        );
    }

    public function testDiffersMissing(): void
    {
        $this->validator->add('test', Rule::differs('other'));

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testDiffersEmpty(): void
    {
        $this->validator->add('test', Rule::differs('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
                'other' => 'test'
            ])
        );
    }

    public function testDiffersOtherEmpty(): void
    {
        $this->validator->add('test', Rule::differs('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => 'test',
                'other' => ''
            ])
        );
    }

    public function testDiffersBothEmpty(): void
    {
        $this->validator->add('test', Rule::differs('other'));

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '',
                'other' => ''
            ])
        );
    }

}
