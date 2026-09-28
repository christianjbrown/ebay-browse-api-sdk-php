<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\HazardStatement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HazardStatement::class)]
final class HazardStatementTest extends TestCase
{
    public function test(): void
    {
        $hazardStatement = new HazardStatement();
        self::assertNull($hazardStatement->getStatementDescription());
        self::assertNull($hazardStatement->getStatementId());

        self::assertSame($hazardStatement, $hazardStatement->setStatementDescription('val_statementDescription'));
        self::assertSame($hazardStatement, $hazardStatement->setStatementId('val_statementId'));

        self::assertSame('val_statementDescription', $hazardStatement->getStatementDescription());
        self::assertSame('val_statementId', $hazardStatement->getStatementId());
    }
}
