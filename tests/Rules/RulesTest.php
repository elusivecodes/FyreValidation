<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Lang\Lang;
use Fyre\Validation\Rule;
use Fyre\Validation\Validator;
use PHPUnit\Framework\TestCase;

final class RulesTest extends TestCase
{
    use AlphaNumericTestTrait;
    use AlphaTestTrait;
    use AsciiTestTrait;
    use BetweenTestTrait;
    use BooleanTestTrait;
    use DateTestTrait;
    use DateTimeTestTrait;
    use DecimalTestTrait;
    use DiffersTestTrait;
    use EmailTestTrait;
    use EmptyTestTrait;
    use EqualsTestTrait;
    use ExactLengthTestTrait;
    use GreaterThanOrEqualsTestTrait;
    use GreaterThanTestTrait;
    use IntegerTestTrait;
    use InTestTrait;
    use IpTestTrait;
    use Ipv4TestTrait;
    use Ipv6TestTrait;
    use LessThanOrEqualsTestTrait;
    use LessThanTestTrait;
    use MatchesTestTrait;
    use MaxLengthTestTrait;
    use MinLengthTestTrait;
    use NaturalNumberTestTrait;
    use NotEmptyTestTrait;
    use RegexTestTrait;
    use RequiredTestTrait;
    use RequirePresenceTestTrait;
    use TimeTestTrait;
    use UrlTestTrait;

    protected Validator $validator;

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
        $this->validator = new Validator();
    }
}
