<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatement;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatementInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductSafetyLabelStatement::class)]
#[CoversClass(ProductSafetyLabelStatementTransformer::class)]
final class ProductSafetyLabelStatementTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ProductSafetyLabelStatementTransformerInterface::KEY_STATEMENT_DESCRIPTION => 'v_1',
            ProductSafetyLabelStatementTransformerInterface::KEY_STATEMENT_ID => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getStatementDescription());
        self::assertSame('v_2', $actual->getStatementId());
    }

    /**
     * @param array<string, mixed>                                $data
     * @param Closure(ProductSafetyLabelStatementInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ProductSafetyLabelStatementInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ProductSafetyLabelStatementInterface $model): void {
                self::assertNull($model->getStatementDescription());
                self::assertNull($model->getStatementId());
            },
        ];

        yield 'statementDescriptionWrongType' => [
            [...$base, ProductSafetyLabelStatementTransformerInterface::KEY_STATEMENT_DESCRIPTION => 42],
            static function (ProductSafetyLabelStatementInterface $model): void {
                self::assertNull($model->getStatementDescription());
            },
        ];

        yield 'statementIdWrongType' => [
            [...$base, ProductSafetyLabelStatementTransformerInterface::KEY_STATEMENT_ID => 42],
            static function (ProductSafetyLabelStatementInterface $model): void {
                self::assertNull($model->getStatementId());
            },
        ];
    }

    private function buildTransformer(): ProductSafetyLabelStatementTransformer
    {

        return new ProductSafetyLabelStatementTransformer();
    }
}
