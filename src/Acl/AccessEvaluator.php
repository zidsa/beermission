<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Acl;

use Yxvt\Beermission\Entity\Bearer;
use Yxvt\Beermission\Entity\Permission;
use Yxvt\Beermission\Entity\Role;

class AccessEvaluator
{
    private Bearer $bearer;

    /** @var array|Role[] */
    private array $roles;

    /** @var array|Permission[] */
    private array $permissions;

    /**
     * @param array|Role[] $expectedRoles
     * @param array|Permission[] $expectedPermissions
     */
    public function __construct(Bearer $bearer, array $expectedRoles, array $expectedPermissions) {
        $this->bearer = $bearer;
        $this->roles = $expectedRoles;
        $this->permissions = $expectedPermissions;
    }

    public function hasAllExpectedGrants(): bool {
        $hasAll = true;

        foreach ($this->roles as $role) {
            $hasAll = $hasAll && $this->bearer->hasRole($role);
        }

        foreach ($this->permissions as $permission) {
            $hasAll = $hasAll && $this->bearer->hasPermission($permission);
        }

        return $hasAll;
    }

    public function hasEitherExpectedGrant(): bool {
        $hasEither = false;

        foreach ($this->roles as $role) {
            $hasEither = $hasEither || $this->bearer->hasRole($role);
        }

        foreach ($this->permissions as $permission) {
            $hasEither = $hasEither || $this->bearer->hasPermission($permission);
        }

        return $hasEither;
    }
}
