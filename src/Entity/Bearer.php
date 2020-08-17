<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Entity;

class Bearer
{
    private string $id;
    private GrantBag $roles;
    private GrantBag $permissions;

    public function __construct(
        string $id,
        GrantBag $roles,
        GrantBag $permissions
    ) {
        $this->id = $id;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function assignRole(Grant $role): void {
        $this->roles->add($role);
    }

    public function hasRole(Grant $role): bool {
        return $this->roles->hasConcrete($role) || $this->roles->hasGeneric($role);
    }

    public function grantPermission(Grant $permission): void {
        $this->permissions->add($permission);
    }

    public function hasPermission(Grant $permission): bool {
        return $this->permissions->hasConcrete($permission) || $this->permissions->hasGeneric($permission);
    }

    public function getId(): string {
        return $this->id;
    }

    public function getRoles(): GrantBag {
        return $this->roles;
    }

    public function getPermissions(): GrantBag {
        return $this->permissions;
    }
}
