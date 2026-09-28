<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HazardStatementsTransformer::class)]
final class HazardStatementsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(HazardStatementInterface::class);
        $second = self::createStub(HazardStatementInterface::class);

        $hazardStatementTransformer = self::createStub(HazardStatementTransformerInterface::class);
        $hazardStatementTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new HazardStatementsTransformer($hazardStatementTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $hazardStatementTransformer = self::createStub(HazardStatementTransformerInterface::class);

        $transformer = new HazardStatementsTransformer($hazardStatementTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(HazardStatementInterface::class);

        $hazardStatementTransformer = self::createMock(HazardStatementTransformerInterface::class);
        $hazardStatementTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new HazardStatementsTransformer($hazardStatementTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $hazardStatementTransformer = self::createStub(HazardStatementTransformerInterface::class);

        $transformer = new HazardStatementsTransformer($hazardStatementTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HazardStatementsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HazardStatementsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
