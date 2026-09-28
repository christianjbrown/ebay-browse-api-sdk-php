<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardStatement;
use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HazardStatement::class)]
#[CoversClass(HazardStatementTransformer::class)]
final class HazardStatementTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HazardStatementTransformerInterface::KEY_STATEMENT_DESCRIPTION => 'v_1',
            HazardStatementTransformerInterface::KEY_STATEMENT_ID => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getStatementDescription());
        self::assertSame('v_2', $actual->getStatementId());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(HazardStatementInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(HazardStatementInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (HazardStatementInterface $model): void {
                self::assertNull($model->getStatementDescription());
                self::assertNull($model->getStatementId());
            },
        ];

        yield 'statementDescriptionWrongType' => [
            [...$base, HazardStatementTransformerInterface::KEY_STATEMENT_DESCRIPTION => 42],
            static function (HazardStatementInterface $model): void {
                self::assertNull($model->getStatementDescription());
            },
        ];

        yield 'statementIdWrongType' => [
            [...$base, HazardStatementTransformerInterface::KEY_STATEMENT_ID => 42],
            static function (HazardStatementInterface $model): void {
                self::assertNull($model->getStatementId());
            },
        ];
    }

    private function buildTransformer(): HazardStatementTransformer
    {

        return new HazardStatementTransformer();
    }
}
