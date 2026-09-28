<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogramInterface;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabels;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelsInterface;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatementInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductSafetyLabels::class)]
#[CoversClass(ProductSafetyLabelsTransformer::class)]
final class ProductSafetyLabelsTransformerTest extends TestCase
{
    private ?ProductSafetyLabelPictogramInterface $productSafetyLabelPictogram = null;
    private ?ProductSafetyLabelStatementInterface $productSafetyLabelStatement = null;

    public function testTransform(): void
    {
        $data = [
            ProductSafetyLabelsTransformerInterface::KEY_PICTOGRAMS => ['raw_pictograms'],
            ProductSafetyLabelsTransformerInterface::KEY_STATEMENTS => ['raw_statements'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->productSafetyLabelPictogram], $actual->getPictograms());
        self::assertSame([$this->productSafetyLabelStatement], $actual->getStatements());
    }

    /**
     * @param array<string, mixed>                        $data
     * @param Closure(ProductSafetyLabelsInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ProductSafetyLabelsInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ProductSafetyLabelsInterface $model): void {
                self::assertSame([], $model->getPictograms());
                self::assertSame([], $model->getStatements());
            },
        ];

        yield 'pictogramsWrongType' => [
            [...$base, ProductSafetyLabelsTransformerInterface::KEY_PICTOGRAMS => 'x'],
            static function (ProductSafetyLabelsInterface $model): void {
                self::assertSame([], $model->getPictograms());
            },
        ];

        yield 'statementsWrongType' => [
            [...$base, ProductSafetyLabelsTransformerInterface::KEY_STATEMENTS => 'x'],
            static function (ProductSafetyLabelsInterface $model): void {
                self::assertSame([], $model->getStatements());
            },
        ];
    }

    private function buildTransformer(): ProductSafetyLabelsTransformer
    {
        $this->productSafetyLabelPictogram = self::createStub(ProductSafetyLabelPictogramInterface::class);
        $this->productSafetyLabelStatement = self::createStub(ProductSafetyLabelStatementInterface::class);

        $productSafetyLabelPictogramsTransformer = self::createStub(ProductSafetyLabelPictogramsTransformerInterface::class);
        $productSafetyLabelPictogramsTransformer->method('transform')->willReturn([$this->productSafetyLabelPictogram]);
        $productSafetyLabelStatementsTransformer = self::createStub(ProductSafetyLabelStatementsTransformerInterface::class);
        $productSafetyLabelStatementsTransformer->method('transform')->willReturn([$this->productSafetyLabelStatement]);

        return new ProductSafetyLabelsTransformer($productSafetyLabelPictogramsTransformer, $productSafetyLabelStatementsTransformer);
    }
}
