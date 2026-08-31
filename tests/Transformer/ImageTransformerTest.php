<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Image;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Image::class)]
#[CoversClass(ImageTransformer::class)]
final class ImageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ImageTransformerInterface::KEY_IMAGE_URL => 'v_0',
            ImageTransformerInterface::KEY_HEIGHT => 101,
            ImageTransformerInterface::KEY_WIDTH => 102,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getImageUrl());
        self::assertSame(101, $actual->getHeight());
        self::assertSame(102, $actual->getWidth());
    }

    /**
     * @param array<string, mixed>          $data
     * @param Closure(ImageInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ImageInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [ImageTransformerInterface::KEY_IMAGE_URL => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ImageInterface $model): void {
                self::assertNull($model->getHeight());
                self::assertNull($model->getWidth());
            },
        ];

        yield 'heightWrongType' => [
            [...$base, ImageTransformerInterface::KEY_HEIGHT => 'x'],
            static function (ImageInterface $model): void {
                self::assertNull($model->getHeight());
            },
        ];

        yield 'heightZero' => [
            [...$base, ImageTransformerInterface::KEY_HEIGHT => 0],
            static function (ImageInterface $model): void {
                self::assertSame(0, $model->getHeight());
            },
        ];

        yield 'widthWrongType' => [
            [...$base, ImageTransformerInterface::KEY_WIDTH => 'x'],
            static function (ImageInterface $model): void {
                self::assertNull($model->getWidth());
            },
        ];

        yield 'widthZero' => [
            [...$base, ImageTransformerInterface::KEY_WIDTH => 0],
            static function (ImageInterface $model): void {
                self::assertSame(0, $model->getWidth());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ImageTransformerInterface::KEY_IMAGE_URL => 42]])]
    public function testTransformThrowsOnInvalidImageUrl(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ImageTransformerInterface::UNEXPECTED_STRING_SPRINTF, ImageTransformerInterface::KEY_IMAGE_URL));

        $transformer->transform($data);
    }

    private function buildTransformer(): ImageTransformer
    {
        return new ImageTransformer();
    }
}
