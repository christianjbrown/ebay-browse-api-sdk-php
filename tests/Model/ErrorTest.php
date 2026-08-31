<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Error;
use ChristianBrown\EBay\Browse\Model\ErrorParameterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Error::class)]
final class ErrorTest extends TestCase
{
    public function test(): void
    {
        $parameters = [self::createStub(ErrorParameterInterface::class)];

        $error = new Error();
        self::assertNull($error->getCategory());
        self::assertNull($error->getDomain());
        self::assertNull($error->getErrorId());
        self::assertSame([], $error->getInputRefIds());
        self::assertNull($error->getLongMessage());
        self::assertNull($error->getMessage());
        self::assertSame([], $error->getOutputRefIds());
        self::assertSame([], $error->getParameters());
        self::assertNull($error->getSubdomain());

        self::assertSame($error, $error->setCategory('v_51'));
        self::assertSame($error, $error->setDomain('v_52'));
        self::assertSame($error, $error->setErrorId(153));
        self::assertSame($error, $error->setInputRefIds(['s_54']));
        self::assertSame($error, $error->setLongMessage('v_55'));
        self::assertSame($error, $error->setMessage('v_56'));
        self::assertSame($error, $error->setOutputRefIds(['s_57']));
        self::assertSame($error, $error->setParameters($parameters));
        self::assertSame($error, $error->setSubdomain('v_59'));

        self::assertSame('v_51', $error->getCategory());
        self::assertSame('v_52', $error->getDomain());
        self::assertSame(153, $error->getErrorId());
        self::assertSame(['s_54'], $error->getInputRefIds());
        self::assertSame('v_55', $error->getLongMessage());
        self::assertSame('v_56', $error->getMessage());
        self::assertSame(['s_57'], $error->getOutputRefIds());
        self::assertSame($parameters, $error->getParameters());
        self::assertSame('v_59', $error->getSubdomain());
    }
}
