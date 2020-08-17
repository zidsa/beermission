<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Domain;

abstract class Grant
{
    private string $name;
    private Scope $scope;

    public function __construct(string $name, Scope $scope) {
        $this->name = $name;
        $this->scope = $scope;
    }

    public function name(): string {
        return $this->name;
    }

    public function scope(): Scope {
        return $this->scope;
    }

    public function isGeneric(): bool {
        return $this->scope->getValue() === null;
    }
}
