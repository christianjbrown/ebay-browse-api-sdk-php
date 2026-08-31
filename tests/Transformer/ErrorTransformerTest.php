<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Error;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ErrorParameterInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Error::class)]
#[CoversClass(ErrorTransformer::class)]
final class ErrorTransformerTest extends TestCase
{
    private ?ErrorParameterInterface $errorParameter = null;

    public function testTransform(): void
    {
        $data = [
            ErrorTransformerInterface::KEY_CATEGORY => 'v_0',
            ErrorTransformerInterface::KEY_DOMAIN => 'v_1',
            ErrorTransformerInterface::KEY_ERROR_ID => 102,
            ErrorTransformerInterface::KEY_INPUT_REF_IDS => ['raw_inputRefIds'],
            ErrorTransformerInterface::KEY_LONG_MESSAGE => 'v_4',
            ErrorTransformerInterface::KEY_MESSAGE => 'v_5',
            ErrorTransformerInterface::KEY_OUTPUT_REF_IDS => ['raw_outputRefIds'],
            ErrorTransformerInterface::KEY_PARAMETERS => ['raw_parameters'],
            ErrorTransformerInterface::KEY_SUBDOMAIN => 'v_8',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCategory());
        self::assertSame('v_1', $actual->getDomain());
        self::assertSame(102, $actual->getErrorId());
        self::assertSame(['s'], $actual->getInputRefIds());
        self::assertSame('v_4', $actual->getLongMessage());
        self::assertSame('v_5', $actual->getMessage());
        self::assertSame(['s'], $actual->getOutputRefIds());
        self::assertSame([$this->errorParameter], $actual->getParameters());
        self::assertSame('v_8', $actual->getSubdomain());
    }

    /**
     * @param array<string, mixed>          $data
     * @param Closure(ErrorInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ErrorInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ErrorInterface $model): void {
                self::assertNull($model->getCategory());
                self::assertNull($model->getDomain());
                self::assertNull($model->getErrorId());
                self::assertSame([], $model->getInputRefIds());
                self::assertNull($model->getLongMessage());
                self::assertNull($model->getMessage());
                self::assertSame([], $model->getOutputRefIds());
                self::assertSame([], $model->getParameters());
                self::assertNull($model->getSubdomain());
            },
        ];

        yield 'categoryWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_CATEGORY => 42],
            static function (ErrorInterface $model): void {
                self::assertNull($model->getCategory());
            },
        ];

        yield 'domainWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_DOMAIN => 42],
            static function (ErrorInterface $model): void {
                self::assertNull($model->getDomain());
            },
        ];

        yield 'errorIdWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_ERROR_ID => 'x'],
            static function (ErrorInterface $model): void {
                self::assertNull($model->getErrorId());
            },
        ];

        yield 'errorIdZero' => [
            [...$base, ErrorTransformerInterface::KEY_ERROR_ID => 0],
            static function (ErrorInterface $model): void {
                self::assertSame(0, $model->getErrorId());
            },
        ];

        yield 'inputRefIdsWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_INPUT_REF_IDS => 'x'],
            static function (ErrorInterface $model): void {
                self::assertSame([], $model->getInputRefIds());
            },
        ];

        yield 'longMessageWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_LONG_MESSAGE => 42],
            static function (ErrorInterface $model): void {
                self::assertNull($model->getLongMessage());
            },
        ];

        yield 'messageWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_MESSAGE => 42],
            static function (ErrorInterface $model): void {
                self::assertNull($model->getMessage());
            },
        ];

        yield 'outputRefIdsWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_OUTPUT_REF_IDS => 'x'],
            static function (ErrorInterface $model): void {
                self::assertSame([], $model->getOutputRefIds());
            },
        ];

        yield 'parametersWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_PARAMETERS => 'x'],
            static function (ErrorInterface $model): void {
                self::assertSame([], $model->getParameters());
            },
        ];

        yield 'subdomainWrongType' => [
            [...$base, ErrorTransformerInterface::KEY_SUBDOMAIN => 42],
            static function (ErrorInterface $model): void {
                self::assertNull($model->getSubdomain());
            },
        ];
    }

    private function buildTransformer(): ErrorTransformer
    {
        $this->errorParameter = self::createStub(ErrorParameterInterface::class);

        $errorParametersTransformer = self::createStub(ErrorParametersTransformerInterface::class);
        $errorParametersTransformer->method('transform')->willReturn([$this->errorParameter]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new ErrorTransformer($errorParametersTransformer, $stringsTransformer);
    }
}
