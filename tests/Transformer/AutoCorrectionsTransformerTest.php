<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AutoCorrections;
use ChristianBrown\EBay\Browse\Model\AutoCorrectionsInterface;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutoCorrections::class)]
#[CoversClass(AutoCorrectionsTransformer::class)]
final class AutoCorrectionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AutoCorrectionsTransformerInterface::KEY_Q => 'v_0',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getQ());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(AutoCorrectionsInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AutoCorrectionsInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AutoCorrectionsInterface $model): void {
                self::assertNull($model->getQ());
            },
        ];

        yield 'qWrongType' => [
            [...$base, AutoCorrectionsTransformerInterface::KEY_Q => 42],
            static function (AutoCorrectionsInterface $model): void {
                self::assertNull($model->getQ());
            },
        ];
    }

    private function buildTransformer(): AutoCorrectionsTransformer
    {
        return new AutoCorrectionsTransformer();
    }
}
