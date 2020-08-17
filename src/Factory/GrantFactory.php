<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Factory;

use Yxvt\Beermission\Entity\Permission;
use Yxvt\Beermission\Entity\Role;
use Yxvt\Beermission\Entity\Scope;
use Yxvt\Beermission\Exception\InvalidStringifiedGrant;
use Yxvt\Beermission\Service\ValidateStringifiedGrantService;

class GrantFactory
{
    private ValidateStringifiedGrantService $validateStringifiedGrantService;

    public function __construct(ValidateStringifiedGrantService $service) {
        $this->validateStringifiedGrantService = $service;
    }

    public function roleFromString(string $stringifiedGrant): Role {
        $this->validateStringifiedGrant($stringifiedGrant);

        [$name, $scope, $value] = explode(';', $stringifiedGrant);

        return new Role($name, new Scope($scope, $value));
    }

    public function permissionFromString(string $stringifiedGrant): Permission {
        $this->validateStringifiedGrant($stringifiedGrant);

        [$name, $scope, $value] = explode(';', $stringifiedGrant);

        return new Permission($name, new Scope($scope, $value));
    }

    private function validateStringifiedGrant(string $stringifiedGrant): void {
        if ($this->validateStringifiedGrantService->isValid($stringifiedGrant) === false) {
            throw new InvalidStringifiedGrant();
        }
    }
}
