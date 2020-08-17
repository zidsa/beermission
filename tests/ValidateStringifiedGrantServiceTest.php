<?php

declare(strict_types=1);

namespace Yxvt\Beermission\Test;

use PHPUnit\Framework\TestCase;
use Yxvt\Beermission\Service\ValidateStringifiedGrantService;

class ValidateStringifiedGrantServiceTest extends TestCase
{
    private ValidateStringifiedGrantService $service;

    protected function setUp(): void {
        parent::setUp();

        $this->service = new ValidateStringifiedGrantService();
    }

    public function testServiceAcceptsValidStringifiedGrant(): void {
        $this->assertTrue($this->service->isValid('grantName;scopeName;scopeValue'));
    }

    public function testServiceRejectsInvalidStringifiedGrant(): void {
        $this->assertFalse($this->service->isValid('grantName;;'));
        $this->assertFalse($this->service->isValid('grantName:scopeName:scopeValue'));
        $this->assertFalse($this->service->isValid(';;;'));
        $this->assertFalse($this->service->isValid('invalid'));
    }
}
