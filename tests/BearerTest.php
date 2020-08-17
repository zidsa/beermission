<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Domain\Bearer;
use Yxvt\Beermission\Domain\Grant;
use Yxvt\Beermission\Domain\GrantBag;
use Yxvt\Beermission\Domain\GrantIndexBuilder;
use Yxvt\Beermission\Domain\Scope;
use PHPUnit\Framework\TestCase;

class BearerTest extends TestCase
{
    public function testBearerIsAbleToCheckRolesAndPermissions(): void {
        $bearer = new Bearer(
            'bearerId',
            $this->createGrantBag(
                $this->createGrant('GenericRole', 'GenericScope'),
                $this->createGrant('ConcreteRole', 'ConcreteScope', 'ConcreteValue'),
            ),
            $this->createGrantBag(
                $this->createGrant('GenericPermission', 'GenericScope'),
                $this->createGrant('ConcretePermission', 'ConcreteScope', 'ConcreteValue'),
            ),
        );

        $this->assertTrue($bearer->hasRole($this->createGrant('GenericRole', 'GenericScope')));
        $this->assertTrue($bearer->hasRole($this->createGrant('GenericRole', 'GenericScope', 'GenericScopeValue')));
        $this->assertTrue($bearer->hasRole($this->createGrant('ConcreteRole', 'ConcreteScope', 'ConcreteValue')));
        $this->assertFalse($bearer->hasRole($this->createGrant('GenericRole', 'OtherScope')));
        $this->assertFalse($bearer->hasRole($this->createGrant('ConcreteRole', 'ConcreteScope')));

        $this->assertTrue($bearer->hasPermission($this->createGrant('GenericPermission', 'GenericScope')));
        $this->assertTrue($bearer->hasPermission($this->createGrant('GenericPermission', 'GenericScope', 'GenericScopeValue')));
        $this->assertTrue($bearer->hasPermission($this->createGrant('ConcretePermission', 'ConcreteScope', 'ConcreteValue')));
        $this->assertFalse($bearer->hasPermission($this->createGrant('GenericPermission', 'OtherScope')));
        $this->assertFalse($bearer->hasPermission($this->createGrant('ConcretePermission', 'ConcreteScope')));
    }

    public function testBearerCanBeGrantedPermissions(): void {
        $bearer = new Bearer('bearer', $this->createGrantBag(), $this->createGrantBag());
        $bearer->grantPermission($this->createGrant('Permission', 'Scope'));

        $this->assertTrue($bearer->hasPermission($this->createGrant('Permission', 'Scope')));
    }

    public function testBearerCanBeAssignedWithRole(): void {
        $bearer = new Bearer('bearer', $this->createGrantBag(), $this->createGrantBag());
        $bearer->assignRole($this->createGrant('Role', 'Scope'));

        $this->assertTrue($bearer->hasRole($this->createGrant('Role', 'Scope')));
    }

    private function createGrantBag(Grant ...$grants): GrantBag
    {
        return new GrantBag(new GrantIndexBuilder(), ...$grants);
    }

    private function createGrant(string $name, string $scope, ?string $scopeValue = null): Grant
    {
        $grant = $this->createMock(Grant::class);
        $grant->method('name')->willReturn($name);
        $grant->method('scope')->willReturn(new Scope($scope, $scopeValue));

        return $grant;
    }
}
