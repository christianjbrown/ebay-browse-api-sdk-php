<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductIdentity;
use ChristianBrown\EBay\Browse\Model\ProductIdentityInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentityTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentityTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductIdentity::class)]
#[CoversClass(ProductIdentityTransformer::class)]
final class ProductIdentityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ProductIdentityTransformerInterface::KEY_IDENTIFIER_TYPE => 'v_1',
            ProductIdentityTransformerInterface::KEY_IDENTIFIER_VALUE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getIdentifierType());
        self::assertSame('v_2', $actual->getIdentifierValue());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(ProductIdentityInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ProductIdentityInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ProductIdentityInterface $model): void {
                self::assertNull($model->getIdentifierType());
                self::assertNull($model->getIdentifierValue());
            },
        ];

        yield 'identifierTypeWrongType' => [
            [...$base, ProductIdentityTransformerInterface::KEY_IDENTIFIER_TYPE => 42],
            static function (ProductIdentityInterface $model): void {
                self::assertNull($model->getIdentifierType());
            },
        ];

        yield 'identifierValueWrongType' => [
            [...$base, ProductIdentityTransformerInterface::KEY_IDENTIFIER_VALUE => 42],
            static function (ProductIdentityInterface $model): void {
                self::assertNull($model->getIdentifierValue());
            },
        ];
    }

    private function buildTransformer(): ProductIdentityTransformer
    {

        return new ProductIdentityTransformer();
    }
}
