<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Acl\Acl;
use Yxvt\Beermission\Acl\RequiredGrantBuilder;
use Yxvt\Beermission\Entity\Bearer;
use Yxvt\Beermission\Entity\Grant;
use Yxvt\Beermission\Entity\GrantBag;
use Yxvt\Beermission\Entity\Scope;
use PHPUnit\Framework\TestCase;
use Yxvt\Beermission\Service\GrantIndexBuilder;

class AclTest extends TestCase
{
    private Bearer $bearer;
    private Acl $acl;

    protected function setUp(): void {
        parent::setUp();

        $this->bearer = new Bearer(
            'bearerId',
            $this->createGrantBag(
                $this->createGrant('Role', 'RoleScope', 'RoleScopeValue')
            ),
            $this->createGrantBag(
                $this->createGrant('Permission', 'PermissionScope', 'PermissionScopeValue')
            )
        );

        $this->acl = new Acl();
    }

    public function testAclGrantsAccessForBearersHavingAllRequiredGrants(): void {
        $this->assertTrue($this->acl->bearer($this->bearer)
            ->that(static function (RequiredGrantBuilder $grantBuilder): void {
                $grantBuilder->hasRole('Role', 'RoleScope', 'RoleScopeValue');
                $grantBuilder->hasPermission('Permission', 'PermissionScope', 'PermissionScopeValue');
            })
            ->shouldBeGrantedAccessWhen()
            ->hasAllExpectedGrants()
        );
    }

    public function testAclGrantsAccessForBearersHavingSomeRequiredGrants(): void {
        $this->assertTrue($this->acl->bearer($this->bearer)
            ->that(static function (RequiredGrantBuilder $grantBuilder): void {
                $grantBuilder->hasRole('Role', 'RoleScope', 'RoleScopeValue');
                $grantBuilder->hasPermission('OtherPermission', 'PermissionScope', 'PermissionScopeValue');
            })
            ->shouldBeGrantedAccessWhen()
            ->hasEitherExpectedGrant()
        );
    }

    public function testAclDoesNotGrantAccessForBearersHavingInsufficientGrants(): void {
        $this->assertFalse($this->acl->bearer($this->bearer)
            ->that(static function (RequiredGrantBuilder $grantBuilder): void {
                $grantBuilder->hasRole('Role', 'RoleScope', 'RoleScopeValue');
                $grantBuilder->hasPermission('OtherPermission', 'PermissionScope', 'PermissionScopeValue');
            })
            ->shouldBeGrantedAccessWhen()
            ->hasAllExpectedGrants()
        );
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
