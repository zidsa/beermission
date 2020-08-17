<?php

declare(strict_types=1);

use Yxvt\Beermission\Exception\InvalidArrayTypeException;

if (false === function_exists('assertArrayType')) {
    function assertArrayType(array $data, string $expectedType, $exception = null): void {
        foreach ($data as $index => $item) {
            if (false === $item instanceof $expectedType) {
                if ($exception instanceof Exception) {
                    throw $exception;
                }

                if (is_string($exception)) {
                    throw new InvalidArrayTypeException($exception);
                }

                throw InvalidArrayTypeException::create($index, $expectedType, get_class($item));
            }
        }
    }
}
