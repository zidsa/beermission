<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Entity\Grant;
use Yxvt\Beermission\Entity\GrantIndexBuilder;
use Yxvt\Beermission\Entity\Scope;
use PHPUnit\Framework\TestCase;

class GrantIndexBuilderTest extends TestCase
{
    private GrantIndexBuilder $builder;

    protected function setUp(): void {
        parent::setUp();

        $this->builder = new GrantIndexBuilder();
    }

    public function testIndexCreationForConcreteGrant(): void {
        $this->assertEquals(
            'Name;Scope;ScopeValue',
            $this->builder->build($this->createGrant('Name', 'Scope', 'ScopeValue'))
        );
    }

    public function testIndexCreationForGenericGrant(): void {
        $this->assertEquals(
            'Name;Scope;',
            $this->builder->build($this->createGrant('Name', 'Scope'))
        );

        $this->assertEquals(
            'Name;Scope;',
            $this->builder->build($this->createGrant('Name', 'Scope', 'ScopeIsIgnored'), true)
        );
    }

    private function createGrant(string $name, string $scope, ?string $scopeValue = null): Grant {
        $grant = $this->createMock(Grant::class);
        $grant->method('name')->willReturn($name);
        $grant->method('scope')->willReturn(new Scope($scope, $scopeValue));

        return $grant;
    }
}
