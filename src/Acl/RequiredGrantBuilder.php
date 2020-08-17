<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Acl;

use Yxvt\Beermission\Entity\Permission;
use Yxvt\Beermission\Entity\Role;
use Yxvt\Beermission\Entity\Scope;

class RequiredGrantBuilder
{
    /** @var array|Role[] */
    private array $hasRoles = [];

    /** @var array|Permission[] */
    private array $hasPermissions = [];

    public function hasRole(string $role, string $scope, ?string $scopeValue = null): self {
        $this->hasRoles[] = new Role($role, new Scope($scope, $scopeValue));

        return $this;
    }

    public function hasPermission(string $permission, string $scope, ?string $scopeValue = null): self {
        $this->hasPermissions[] = new Permission($permission, new Scope($scope, $scopeValue));

        return $this;
    }

    /** @return  array|Role[] */
    public function getHasRoles(): array {
        return $this->hasRoles;
    }

    /** @return array|Permission[] */
    public function getHasPermissions(): array {
        return $this->hasPermissions;
    }
}
