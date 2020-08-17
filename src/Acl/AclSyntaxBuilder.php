<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Acl;

use Yxvt\Beermission\Domain\Bearer;
use Yxvt\Beermission\Domain\Permission;
use Yxvt\Beermission\Domain\Role;
use Yxvt\Beermission\Domain\Scope;

class AclSyntaxBuilder
{
    private Bearer $bearer;

    private array $roles = [];
    private array $permissions = [];

    public function __construct(Bearer $bearer) {
        $this->bearer = $bearer;
    }

    public function withRole(string $role, string $scope, ?string $scopeValue = null): AclSyntaxBuilder {
        $this->roles[] = new Role($role, new Scope($scope, $scopeValue));

        return $this;
    }

    public function withPermission(string $permission, string $scope, ?string $scopeValue = null): AclSyntaxBuilder {
        $this->permissions[] = new Permission($permission, new Scope($scope, $scopeValue));

        return $this;
    }

    public function grantAccessWhen(): ActionSyntaxBuilder {
        return new ActionSyntaxBuilder($this->bearer, $this->roles, $this->permissions);
    }
}
