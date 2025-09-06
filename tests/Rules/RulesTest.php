<?php
declare(strict_types=1);

namespace Tests\Rules;

use Fyre\Config\Config;
use Fyre\Container\Container;
use Fyre\DB\TypeParser;
use Fyre\Lang\Lang;
use Fyre\Utility\Traits\MacroTrait;
use Fyre\Validation\Rule;
use Fyre\Validation\Validator;
use PHPUnit\Framework\TestCase;

use function class_uses;

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

    public function testMacroable(): void
    {
        $this->assertContains(
            MacroTrait::class,
            class_uses(Rule::class)
        );
    }

    protected function setUp(): void
    {
        $container = new Container();
        $container->singleton(TypeParser::class);
        $container->singleton(Lang::class);
        $container->singleton(Config::class);

        $container->use(Config::class)->set('App.locale', 'en');

        $this->validator = $container->use(Validator::class);
    }
}
