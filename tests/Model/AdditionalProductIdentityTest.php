<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentity;
use ChristianBrown\EBay\Browse\Model\ProductIdentityInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AdditionalProductIdentity::class)]
final class AdditionalProductIdentityTest extends TestCase
{
    public function test(): void
    {
        $productIdentity = [self::createStub(ProductIdentityInterface::class)];

        $additionalProductIdentity = new AdditionalProductIdentity();
        self::assertSame([], $additionalProductIdentity->getProductIdentity());

        self::assertSame($additionalProductIdentity, $additionalProductIdentity->setProductIdentity($productIdentity));

        self::assertSame($productIdentity, $additionalProductIdentity->getProductIdentity());
    }
}
