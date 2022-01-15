<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Validation\Rule;

trait IpTest
{

    public function testIp(): void
    {
        $this->validator->add('test', Rule::ip());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '1.1.1.1'
            ])
        );
    }

    public function testIpWithV6(): void
    {
        $this->validator->add('test', Rule::ip());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334'
            ])
        );
    }

    public function testIpInvalid(): void
    {
        $this->validator->add('test', Rule::ip());

        $this->assertSame(
            [
                'test' => ['invalid']
            ],
            $this->validator->validate([
                'test' => 'invalid'
            ])
        );
    }

    public function testIpMissing(): void
    {
        $this->validator->add('test', Rule::ip());

        $this->assertSame(
            [],
            $this->validator->validate([])
        );
    }

    public function testIpEmpty(): void
    {
        $this->validator->add('test', Rule::ip());

        $this->assertSame(
            [],
            $this->validator->validate([
                'test' => ''
            ])
        );
    }

}
