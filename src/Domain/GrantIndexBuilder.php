<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Domain;

class GrantIndexBuilder
{
    public function build(Grant $grant, bool $forceGeneric = false): string {
        return implode(';', [
            $grant->name(),
            $grant->scope()->getName(),
            $grant->isGeneric() || $forceGeneric ? null : $grant->scope()->getValue(),
        ]);
    }
}
