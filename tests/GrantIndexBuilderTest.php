<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use Yxvt\Beermission\Entity\Grant;
use Yxvt\Beermission\Entity\Scope;
use PHPUnit\Framework\TestCase;
use Yxvt\Beermission\Service\BuildGrantIndexService;

class GrantIndexBuilderTest extends TestCase
{
    private BuildGrantIndexService $service;

    protected function setUp(): void {
        parent::setUp();

        $this->service = new BuildGrantIndexService();
    }

    public function testIndexCreationForConcreteGrant(): void {
        $this->assertEquals(
            'Name;Scope;ScopeValue',
            $this->service->build($this->createGrant('Name', 'Scope', 'ScopeValue'))
        );
    }

    public function testIndexCreationForGenericGrant(): void {
        $this->assertEquals(
            'Name;Scope;',
            $this->service->build($this->createGrant('Name', 'Scope'))
        );

        $this->assertEquals(
            'Name;Scope;',
            $this->service->build($this->createGrant('Name', 'Scope', 'ScopeIsIgnored'), true)
        );
    }

    private function createGrant(string $name, string $scope, ?string $scopeValue = null): Grant {
        $grant = $this->createMock(Grant::class);
        $grant->method('name')->willReturn($name);
        $grant->method('scope')->willReturn(new Scope($scope, $scopeValue));

        return $grant;
    }
}
