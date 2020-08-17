<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Acl\Acl;
use Yxvt\Beermission\Domain\Bearer;
use Yxvt\Beermission\Domain\Grant;
use Yxvt\Beermission\Domain\GrantBag;
use Yxvt\Beermission\Domain\GrantIndexBuilder;
use Yxvt\Beermission\Domain\Scope;
use PHPUnit\Framework\TestCase;

class AclTest extends TestCase
{
    public function testAclWithBearerHavingEveryGrant(): void {
        $bearer = new Bearer(
            'bearerId',
            $this->createGrantBag($this->createGrant('RoleGrant', 'Role')),
            $this->createGrantBag($this->createGrant('PermissionGrant', 'Permission')),
        );

        $acl = new Acl();

        $acl->bearer($bearer)
            ->withRole('RoleGrant', 'RoleScope', 'RoleScopeValue')
            ->withPermission('PermissionGrant', 'PermissionScope', 'PermissionScopeValue')
            ->grantAccessWhen()
            ->hasEveryGrant();

        $builder = $acl->bearer($bearer)
            ->withRole('RoleGrant', 'Role')
            ->withPermission('PermissionGrant', 'Permission');

        $this->assertTrue($builder->grantAccessWhen()->hasEveryGrant());
        $this->assertTrue($builder->grantAccessWhen()->hasEitherGrant());
    }

    public function testAclWithBearerHavingOnlySomeGrants(): void {
        $bearer = new Bearer(
            'bearerId',
            $this->createGrantBag($this->createGrant('RoleGrant', 'Role')),
            $this->createGrantBag($this->createGrant('PermissionGrant', 'Permission')),
        );

        $acl = new Acl();
        $builder = $acl->bearer($bearer)
            ->withRole('SomeOtherRole', 'Role')
            ->withPermission('PermissionGrant', 'Permission');

        $this->assertFalse($builder->grantAccessWhen()->hasEveryGrant());
        $this->assertTrue($builder->grantAccessWhen()->hasEitherGrant());
    }

    public function testAclWithBearerHavingNoneRequiredGrants(): void {
        $bearer = new Bearer(
            'bearerId',
            $this->createGrantBag($this->createGrant('RoleGrant', 'Role')),
            $this->createGrantBag($this->createGrant('PermissionGrant', 'Permission')),
        );

        $acl = new Acl();
        $builder = $acl->bearer($bearer)
            ->withRole('SomeOtherRole', 'Role')
            ->withPermission('SomeOtherPermission', 'Permission');

        $this->assertFalse($builder->grantAccessWhen()->hasEveryGrant());
        $this->assertFalse($builder->grantAccessWhen()->hasEitherGrant());
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
