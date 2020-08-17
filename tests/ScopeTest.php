<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Domain\Scope;
use PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{
    /** @dataProvider scopeData */
    public function test(Scope $left, Scope $right, bool $shouldBeEqual) {
        $this->assertEquals($shouldBeEqual, $left->eq($right));
    }

    public function scopeData(): array {
        return [
            'Equity between concrete Scopes' => [
                new Scope('Name', 'Value'),
                new Scope('Name', 'Value'),
                true
            ],

            'Inequity in names between concrete Scopes' => [
                new Scope('Name', 'Value'),
                new Scope('OtherName', 'Value'),
                false
            ],

            'Inequity in values between concrete Scopes' => [
                new Scope('Name', 'Value'),
                new Scope('Name', 'OtherValue'),
                false
            ],

            'Equity between Generic Scope and Concrete Scope' => [
                new Scope('Name'),
                new Scope('Name', 'Value'),
                true
            ],

            'Inequity between Concrete Scope and Generic Scope' => [
                new Scope('Name', 'Value'),
                new Scope('Name'),
                false
            ],

            'Equity between Generic Scopes' => [
                new Scope('Name'),
                new Scope('Name'),
                true
            ],

            'Inequity between Generic Scopes' => [
                new Scope('Name'),
                new Scope('OtherName'),
                false
            ],
        ];
    }
}
