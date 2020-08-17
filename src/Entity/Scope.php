<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Entity;

class Scope
{
    private string $name;
    private ?string $value;

    public function __construct(string $name, ?string $value = null) {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue(): ?string {
        return $this->value;
    }

    public function eq(Scope $other): bool {
        if ($this->value === null) {
            return $this->name === $other->name;
        }

        return $this->name === $other->name && $this->value === $other->value;
    }
}
