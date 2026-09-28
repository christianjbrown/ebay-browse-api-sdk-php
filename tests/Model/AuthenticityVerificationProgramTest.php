<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgram;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthenticityVerificationProgram::class)]
final class AuthenticityVerificationProgramTest extends TestCase
{
    public function test(): void
    {
        $authenticityVerificationProgram = new AuthenticityVerificationProgram();
        self::assertNull($authenticityVerificationProgram->getDescription());
        self::assertNull($authenticityVerificationProgram->getTermsWebUrl());

        self::assertSame($authenticityVerificationProgram, $authenticityVerificationProgram->setDescription('val_description'));
        self::assertSame($authenticityVerificationProgram, $authenticityVerificationProgram->setTermsWebUrl('val_termsWebUrl'));

        self::assertSame('val_description', $authenticityVerificationProgram->getDescription());
        self::assertSame('val_termsWebUrl', $authenticityVerificationProgram->getTermsWebUrl());
    }
}
