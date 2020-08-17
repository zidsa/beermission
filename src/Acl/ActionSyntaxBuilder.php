<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Acl;

use Yxvt\Beermission\Domain\Bearer;
use Yxvt\Beermission\Domain\Permission;
use Yxvt\Beermission\Domain\Role;

class ActionSyntaxBuilder
{
    private Bearer $bearer;

    /** @var array|Role[] */
    private array $roles;

    /** @var array|Permission[] */
    private array $permissions;

    public function __construct(Bearer $bearer, array $roles, array $permissions) {
        $this->bearer = $bearer;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function hasEveryGrant(): bool {
        return $this->every();
    }

    public function hasEitherGrant(): bool {
        return $this->either();
    }

    private function every(): bool {
        $hasEvery = true;

        foreach ($this->roles as $role) {
            $hasEvery = $hasEvery && $this->bearer->hasRole($role);
        }

        foreach ($this->permissions as $permission) {
            $hasEvery = $hasEvery && $this->bearer->hasPermission($permission);
        }

        return $hasEvery;
    }

    private function either(): bool {
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
