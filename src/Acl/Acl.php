<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Acl;

use Yxvt\Beermission\Domain\Bearer;

class Acl
{
    public function bearer(Bearer $bearer): AclSyntaxBuilder {
        return new AclSyntaxBuilder($bearer);
    }
}
