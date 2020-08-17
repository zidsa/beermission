<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Factory;

use Yxvt\Beermission\Domain\Permission;
use Yxvt\Beermission\Domain\Role;
use Yxvt\Beermission\Domain\Scope;
use Yxvt\Beermission\Exception\InvalidStringifiedGrant;

class GrantFactory
{
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
        if (preg_match('/^.+;.+;(.+)?$/m', $stringifiedGrant) === 0) {
            throw new InvalidStringifiedGrant();
        }
    }
}
