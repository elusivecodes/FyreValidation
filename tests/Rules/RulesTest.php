<?php
declare(strict_types=1);

namespace Tests\Rules;

use
    Fyre\Lang\Lang,
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

    public static function setUpBeforeClass(): void
    {
        Lang::clear();
    }
    
    protected function setUp(): void
    {
        $this->validator = new Validator;
    }

}
