<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Lang\Lang,
    Fyre\Validation\Rule,
    Fyre\Validation\Validator,
    PHPUnit\Framework\TestCase;

final class RulesTest extends TestCase
{

    protected Validator $validator;

    use
        AlphaTest,
        AlphaNumericTest,
        AsciiTest,
        BetweenTest,
        BooleanTest,
        DateTest,
        DateTimeTest,
        DecimalTest,
        DiffersTest,
        EmailTest,
        EmptyTest,
        EqualsTest,
        ExactLengthTest,
        GreaterThanOrEqualsTest,
        GreaterThanTest,
        InTest,
        IntegerTest,
        IpTest,
        Ipv4Test,
        Ipv6Test,
        LessThanOrEqualsTest,
        LessThanTest,
        MatchesTest,
        MaxLengthTest,
        MinLengthTest,
        NaturalNumberTest,
        RegexTest,
        RequiredTest,
        TimeTest,
        UrlTest;

    public function testGetArguments(): void
    {
        $rule = Rule::between(5, 10);

        $this->assertSame(
            [5, 10],
            $rule->getArguments()
        );
    }
    
    public function testGetName(): void
    {
        $rule = Rule::alpha();

        $this->assertSame(
            'alpha',
            $rule->getName()
        );
    }

    public static function setUpBeforeClass(): void
    {
        Lang::clear();
    }
    
    protected function setUp(): void
    {
        $this->validator = new Validator;
    }

}
