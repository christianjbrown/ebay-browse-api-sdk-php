<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CompatibilityResponse;
use ChristianBrown\EBay\Browse\Model\CompatibilityResponseInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompatibilityResponse::class)]
#[CoversClass(CompatibilityResponseTransformer::class)]
final class CompatibilityResponseTransformerTest extends TestCase
{
    private ?ErrorInterface $error = null;

    public function testTransform(): void
    {
        $data = [
            CompatibilityResponseTransformerInterface::KEY_COMPATIBILITY_STATUS => 'v_0',
            CompatibilityResponseTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCompatibilityStatus());
        self::assertSame([$this->error], $actual->getWarnings());
    }

    /**
     * @param array<string, mixed>                          $data
     * @param Closure(CompatibilityResponseInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CompatibilityResponseInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CompatibilityResponseInterface $model): void {
                self::assertNull($model->getCompatibilityStatus());
                self::assertSame([], $model->getWarnings());
            },
        ];

        yield 'compatibilityStatusWrongType' => [
            [...$base, CompatibilityResponseTransformerInterface::KEY_COMPATIBILITY_STATUS => 42],
            static function (CompatibilityResponseInterface $model): void {
                self::assertNull($model->getCompatibilityStatus());
            },
        ];

        yield 'warningsWrongType' => [
            [...$base, CompatibilityResponseTransformerInterface::KEY_WARNINGS => 'x'],
            static function (CompatibilityResponseInterface $model): void {
                self::assertSame([], $model->getWarnings());
            },
        ];
    }

    private function buildTransformer(): CompatibilityResponseTransformer
    {
        $this->error = self::createStub(ErrorInterface::class);

        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);

        return new CompatibilityResponseTransformer($errorsTransformer);
    }
}
