<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgram;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthenticityGuaranteeProgram::class)]
final class AuthenticityGuaranteeProgramTest extends TestCase
{
    public function test(): void
    {
        $authenticityGuaranteeProgram = new AuthenticityGuaranteeProgram();
        self::assertNull($authenticityGuaranteeProgram->getDescription());
        self::assertNull($authenticityGuaranteeProgram->getTermsWebUrl());

        self::assertSame($authenticityGuaranteeProgram, $authenticityGuaranteeProgram->setDescription('val_description'));
        self::assertSame($authenticityGuaranteeProgram, $authenticityGuaranteeProgram->setTermsWebUrl('val_termsWebUrl'));

        self::assertSame('val_description', $authenticityGuaranteeProgram->getDescription());
        self::assertSame('val_termsWebUrl', $authenticityGuaranteeProgram->getTermsWebUrl());
    }
}
