<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Entity\Grant;
use Yxvt\Beermission\Entity\GrantBag;
use Yxvt\Beermission\Entity\Scope;
use PHPUnit\Framework\TestCase;
use Yxvt\Beermission\Service\GrantIndexBuilder;

class GrantBagTest extends TestCase
{
    public function testBagDropsParticularGrant(): void {
        $grant = $this->createMock(Grant::class);
        $grant->method('name')->willReturn('GrantName');
        $grant->method('scope')->willReturn(new Scope('Scope', 'Value'));

        $bag = new GrantBag(new GrantIndexBuilder());
        $bag->add($grant);
        $bag->drop($grant);

        $this->assertFalse($bag->hasConcrete($grant));
    }

    /** @dataProvider bagContainsConcreteGrantProvider */
    public function testBagContainsConcreteGrant(Grant $grant, Grant $target, bool $expectedResult): void {
        $bag = new GrantBag(new GrantIndexBuilder(), $grant);

        $this->assertEquals($expectedResult, $bag->hasConcrete($target));
    }

    public function bagContainsConcreteGrantProvider(): array {
        return [
            'Concrete grant compared against identical concrete grant' => [
                $this->createGrant('Grant', 'Scope', 'Value'),
                $this->createGrant('Grant', 'Scope', 'Value'),
                true,
            ],

            'Concrete grant compared against other concrete grant' => [
                $this->createGrant('Grant', 'Scope', 'Value'),
                $this->createGrant('OtherGrant', 'Scope', 'Value'),
                false,
            ],

            'Concrete grant compared against other concrete grant but with different scope' => [
                $this->createGrant('Grant', 'Scope', 'Value'),
                $this->createGrant('Grant', 'OtherScope', 'Value'),
                false,
            ],

            'Concrete grant compared against generic grant' => [
                $this->createGrant('Grant', 'Scope', 'Value'),
                $this->createGrant('Grant', 'Scope'),
                false,
            ],
        ];
    }

    /** @dataProvider bagContainsGenericGrantProvider */
    public function testBagContainsGenericGrant(Grant $grant, Grant $target, bool $expectedResult): void {
        $bag = new GrantBag(new GrantIndexBuilder(), $grant);

        $this->assertEquals($expectedResult, $bag->hasGeneric($target));
    }

    public function bagContainsGenericGrantProvider(): array {
        return [
            'Generic grant compared against identical generic grant' => [
                $this->createGrant('Grant', 'Scope'),
                $this->createGrant('Grant', 'Scope'),
                true,
            ],

            'Generic grant compared against other generic grant' => [
                $this->createGrant('Grant', 'Scope'),
                $this->createGrant('OtherGrant', 'Scope'),
                false,
            ],

            'Generic grant compared against generic grant with different scope' => [
                $this->createGrant('Grant', 'Scope'),
                $this->createGrant('Grant', 'OtherScope'),
                false,
            ],

            'Generic grant compared against concrete grant' => [
                $this->createGrant('Grant', 'Scope'),
                $this->createGrant('Grant', 'Scope', 'Value'),
                true,
            ],
        ];
    }

    private function createGrant(string $name, string $scope, ?string $scopeValue = null): Grant
    {
        $grant = $this->createMock(Grant::class);
        $grant->method('name')->willReturn($name);
        $grant->method('scope')->willReturn(new Scope($scope, $scopeValue));

        return $grant;
    }
}
