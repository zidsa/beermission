<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Domain\GrantIndexBuilder;
use Yxvt\Beermission\Domain\Permission;
use Yxvt\Beermission\Domain\Role;
use Yxvt\Beermission\Domain\Scope;
use Yxvt\Beermission\Exception\InvalidStringifiedGrant;
use Yxvt\Beermission\Factory\GrantFactory;
use PHPUnit\Framework\TestCase;

class GrantFactoryTest extends TestCase
{
    private GrantFactory $factory;
    private GrantIndexBuilder $grantIndexBuilder;

    protected function setUp(): void {
        parent::setUp();

        $this->factory = new GrantFactory();
        $this->grantIndexBuilder = new GrantIndexBuilder();
    }

    public function testGrantFactoryCreatesRole(): void {
        $sourceRole = new Role('Role', new Scope('Scope', 'Value'));
        $role = $this->factory->roleFromString($this->grantIndexBuilder->build($sourceRole));

        $this->assertEquals('Role', $role->name());
        $this->assertEquals('Scope', $role->scope()->getName());
        $this->assertEquals('Value', $role->scope()->getValue());
    }

    public function testGrantFactoryCreatesPermissions(): void {
        $sourcePermission = new Permission('Permission', new Scope('Scope', 'Value'));
        $permission = $this->factory->permissionFromString($this->grantIndexBuilder->build($sourcePermission));

        $this->assertEquals('Permission', $permission->name());
        $this->assertEquals('Scope', $permission->scope()->getName());
        $this->assertEquals('Value', $permission->scope()->getValue());
    }

    public function testGrantFactoryThrowsExceptionIfInvalidStringProvided(): void {
        $this->expectException(InvalidStringifiedGrant::class);

        $this->factory->permissionFromString('Invalid permission');
    }
}
