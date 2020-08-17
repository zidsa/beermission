<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Exception;

use Exception;

class InvalidArrayTypeException extends Exception
{
    public static function create(int $index, string $expectedType, string $actualType): self {
        return new static(
            "Expected instance of $expectedType, given $actualType at index $index"
        );
    }
}
