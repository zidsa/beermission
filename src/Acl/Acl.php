<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Acl;

use Closure;
use Yxvt\Beermission\Entity\Bearer;
use Yxvt\Beermission\Entity\Permission;
use Yxvt\Beermission\Entity\Role;

class Acl
{
    private Bearer $bearer;

    /** @var array|Role[] */
    private array $withRoles = [];

    /** @var array|Permission[] */
    private array $withPermissions = [];

    public function bearer(Bearer $bearer): self {
        $this->bearer = $bearer;

        return $this;
    }

    public function that(Closure $closure): self {
        $closure->__invoke($requiredGrantBuilder = new RequiredGrantBuilder());

        $this->withRoles = $requiredGrantBuilder->getHasRoles();
        $this->withPermissions = $requiredGrantBuilder->getHasPermissions();

        assertArrayType($this->withRoles, Role::class);
        assertArrayType($this->withRoles, Role::class);

        return $this;
    }

    public function shouldBeGrantedAccessWhen(): AccessEvaluator {
        return new AccessEvaluator($this->bearer, $this->withRoles, $this->withPermissions);
    }
}
