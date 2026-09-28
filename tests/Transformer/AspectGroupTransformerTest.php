<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectGroup;
use ChristianBrown\EBay\Browse\Model\AspectGroupInterface;
use ChristianBrown\EBay\Browse\Model\AspectInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AspectGroup::class)]
#[CoversClass(AspectGroupTransformer::class)]
final class AspectGroupTransformerTest extends TestCase
{
    private ?AspectInterface $aspect = null;

    public function testTransform(): void
    {
        $data = [
            AspectGroupTransformerInterface::KEY_ASPECTS => ['raw_aspects'],
            AspectGroupTransformerInterface::KEY_LOCALIZED_GROUP_NAME => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->aspect], $actual->getAspects());
        self::assertSame('v_1', $actual->getLocalizedGroupName());
    }

    /**
     * @param array<string, mixed>                $data
     * @param Closure(AspectGroupInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AspectGroupInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AspectGroupInterface $model): void {
                self::assertSame([], $model->getAspects());
                self::assertNull($model->getLocalizedGroupName());
            },
        ];

        yield 'aspectsWrongType' => [
            [...$base, AspectGroupTransformerInterface::KEY_ASPECTS => 'x'],
            static function (AspectGroupInterface $model): void {
                self::assertSame([], $model->getAspects());
            },
        ];

        yield 'localizedGroupNameWrongType' => [
            [...$base, AspectGroupTransformerInterface::KEY_LOCALIZED_GROUP_NAME => 42],
            static function (AspectGroupInterface $model): void {
                self::assertNull($model->getLocalizedGroupName());
            },
        ];
    }

    private function buildTransformer(): AspectGroupTransformer
    {
        $this->aspect = self::createStub(AspectInterface::class);

        $aspectsTransformer = self::createStub(AspectsTransformerInterface::class);
        $aspectsTransformer->method('transform')->willReturn([$this->aspect]);

        return new AspectGroupTransformer($aspectsTransformer);
    }
}
