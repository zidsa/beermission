<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Service;

class ValidateStringifiedGrantService
{
    public function isValid(string $stringifiedGrant): bool {
        return preg_match('/^.+;.+;(.+)?$/m', $stringifiedGrant) !== 0;
    }
}
