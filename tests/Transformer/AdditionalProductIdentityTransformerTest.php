<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentity;
use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;
use ChristianBrown\EBay\Browse\Model\ProductIdentityInterface;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentityTransformer;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentityTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentitiesTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AdditionalProductIdentity::class)]
#[CoversClass(AdditionalProductIdentityTransformer::class)]
final class AdditionalProductIdentityTransformerTest extends TestCase
{
    private ?ProductIdentityInterface $productIdentity = null;

    public function testTransform(): void
    {
        $data = [
            AdditionalProductIdentityTransformerInterface::KEY_PRODUCT_IDENTITY => ['raw_productIdentity'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->productIdentity], $actual->getProductIdentity());
    }

    /**
     * @param array<string, mixed>                              $data
     * @param Closure(AdditionalProductIdentityInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AdditionalProductIdentityInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AdditionalProductIdentityInterface $model): void {
                self::assertSame([], $model->getProductIdentity());
            },
        ];

        yield 'productIdentityWrongType' => [
            [...$base, AdditionalProductIdentityTransformerInterface::KEY_PRODUCT_IDENTITY => 'x'],
            static function (AdditionalProductIdentityInterface $model): void {
                self::assertSame([], $model->getProductIdentity());
            },
        ];
    }

    private function buildTransformer(): AdditionalProductIdentityTransformer
    {
        $this->productIdentity = self::createStub(ProductIdentityInterface::class);

        $productIdentitiesTransformer = self::createStub(ProductIdentitiesTransformerInterface::class);
        $productIdentitiesTransformer->method('transform')->willReturn([$this->productIdentity]);

        return new AdditionalProductIdentityTransformer($productIdentitiesTransformer);
    }
}
