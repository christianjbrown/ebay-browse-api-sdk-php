<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CommonDescription;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommonDescription::class)]
final class CommonDescriptionTest extends TestCase
{
    public function test(): void
    {
        $commonDescription = new CommonDescription();
        self::assertNull($commonDescription->getDescription());
        self::assertSame([], $commonDescription->getItemIds());

        self::assertSame($commonDescription, $commonDescription->setDescription('v_51'));
        self::assertSame($commonDescription, $commonDescription->setItemIds(['s_52']));

        self::assertSame('v_51', $commonDescription->getDescription());
        self::assertSame(['s_52'], $commonDescription->getItemIds());
    }
}
