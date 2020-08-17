<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Service;

use Yxvt\Beermission\Entity\Grant;

class BuildGrantIndexService
{
    public function build(Grant $grant, bool $forceGeneric = false): string {
        return implode(';', [
            $grant->name(),
            $grant->scope()->getName(),
            $grant->isGeneric() || $forceGeneric ? null : $grant->scope()->getValue(),
        ]);
    }
}
