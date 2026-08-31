<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CompatibilityResponse;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompatibilityResponse::class)]
final class CompatibilityResponseTest extends TestCase
{
    public function test(): void
    {
        $warnings = [self::createStub(ErrorInterface::class)];

        $compatibilityResponse = new CompatibilityResponse();
        self::assertNull($compatibilityResponse->getCompatibilityStatus());
        self::assertSame([], $compatibilityResponse->getWarnings());

        self::assertSame($compatibilityResponse, $compatibilityResponse->setCompatibilityStatus('v_51'));
        self::assertSame($compatibilityResponse, $compatibilityResponse->setWarnings($warnings));

        self::assertSame('v_51', $compatibilityResponse->getCompatibilityStatus());
        self::assertSame($warnings, $compatibilityResponse->getWarnings());
    }
}
