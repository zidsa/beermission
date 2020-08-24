<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Entity;

use Yxvt\Beermission\Service\GrantIndexBuilder;

class GrantBag
{
    private GrantIndexBuilder $indexBuilder;

    /** @var array|Grant[] */
    private array $grants = [];

    public function __construct(GrantIndexBuilder $grantIndexBuilder, Grant ...$grants) {
        $this->indexBuilder = $grantIndexBuilder;

        foreach ($grants as $grant) {
            $this->add($grant);
        }
    }

    public function add(Grant $grant): void {
        $this->grants[$this->indexBuilder->build($grant)] = $grant;
    }

    public function hasConcrete(Grant $grant): bool {
        return array_key_exists($this->indexBuilder->build($grant), $this->grants);
    }

    public function hasGeneric(Grant $grant): bool {
        return array_key_exists($this->indexBuilder->build($grant, true), $this->grants);
    }

    public function get(Grant $grant): Grant {
        return $this->grants[$this->indexBuilder->build($grant)];
    }

    public function drop(Grant $grant): void {
        if ($this->hasConcrete($grant)) {
            unset($this->grants[$this->indexBuilder->build($grant)]);
        }
    }

    /** @return array|Grant[] */
    public function toArray(): array {
        return $this->grants;
    }
}
