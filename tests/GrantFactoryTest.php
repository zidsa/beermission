<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Entity\Permission;
use Yxvt\Beermission\Entity\Role;
use Yxvt\Beermission\Entity\Scope;
use Yxvt\Beermission\Exception\InvalidStringifiedGrant;
use Yxvt\Beermission\Factory\GrantFactory;
use PHPUnit\Framework\TestCase;
use Yxvt\Beermission\Service\BuildGrantIndexService;
use Yxvt\Beermission\Service\ValidateStringifiedGrantService;

class GrantFactoryTest extends TestCase
{
    private GrantFactory $factory;
    private BuildGrantIndexService $buildGrantIndexService;

    protected function setUp(): void {
        parent::setUp();

        $this->factory = new GrantFactory(new ValidateStringifiedGrantService());
        $this->buildGrantIndexService = new BuildGrantIndexService();
    }

    public function testGrantFactoryCreatesRole(): void {
        $sourceRole = new Role('Role', new Scope('Scope', 'Value'));
        $role = $this->factory->roleFromString($this->buildGrantIndexService->build($sourceRole));

        $this->assertEquals('Role', $role->name());
        $this->assertEquals('Scope', $role->scope()->getName());
        $this->assertEquals('Value', $role->scope()->getValue());
    }

    public function testGrantFactoryCreatesPermissions(): void {
        $sourcePermission = new Permission('Permission', new Scope('Scope', 'Value'));
        $permission = $this->factory->permissionFromString($this->buildGrantIndexService->build($sourcePermission));

        $this->assertEquals('Permission', $permission->name());
        $this->assertEquals('Scope', $permission->scope()->getName());
        $this->assertEquals('Value', $permission->scope()->getValue());
    }

    public function testGrantFactoryThrowsExceptionIfInvalidStringProvided(): void {
        $this->expectException(InvalidStringifiedGrant::class);

        $this->factory->permissionFromString('Invalid permission');
    }
}
