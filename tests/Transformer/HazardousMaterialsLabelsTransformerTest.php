<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabels;
use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabelsInterface;
use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;
use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HazardousMaterialsLabels::class)]
#[CoversClass(HazardousMaterialsLabelsTransformer::class)]
final class HazardousMaterialsLabelsTransformerTest extends TestCase
{
    private ?HazardPictogramInterface $hazardPictogram = null;
    private ?HazardStatementInterface $hazardStatement = null;

    public function testTransform(): void
    {
        $data = [
            HazardousMaterialsLabelsTransformerInterface::KEY_ADDITIONAL_INFORMATION => 'v_1',
            HazardousMaterialsLabelsTransformerInterface::KEY_PICTOGRAMS => ['raw_pictograms'],
            HazardousMaterialsLabelsTransformerInterface::KEY_SIGNAL_WORD => 'v_2',
            HazardousMaterialsLabelsTransformerInterface::KEY_SIGNAL_WORD_ID => 'v_3',
            HazardousMaterialsLabelsTransformerInterface::KEY_STATEMENTS => ['raw_statements'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getAdditionalInformation());
        self::assertSame([$this->hazardPictogram], $actual->getPictograms());
        self::assertSame('v_2', $actual->getSignalWord());
        self::assertSame('v_3', $actual->getSignalWordId());
        self::assertSame([$this->hazardStatement], $actual->getStatements());
    }

    /**
     * @param array<string, mixed>                             $data
     * @param Closure(HazardousMaterialsLabelsInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(HazardousMaterialsLabelsInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (HazardousMaterialsLabelsInterface $model): void {
                self::assertNull($model->getAdditionalInformation());
                self::assertSame([], $model->getPictograms());
                self::assertNull($model->getSignalWord());
                self::assertNull($model->getSignalWordId());
                self::assertSame([], $model->getStatements());
            },
        ];

        yield 'additionalInformationWrongType' => [
            [...$base, HazardousMaterialsLabelsTransformerInterface::KEY_ADDITIONAL_INFORMATION => 42],
            static function (HazardousMaterialsLabelsInterface $model): void {
                self::assertNull($model->getAdditionalInformation());
            },
        ];

        yield 'pictogramsWrongType' => [
            [...$base, HazardousMaterialsLabelsTransformerInterface::KEY_PICTOGRAMS => 'x'],
            static function (HazardousMaterialsLabelsInterface $model): void {
                self::assertSame([], $model->getPictograms());
            },
        ];

        yield 'signalWordWrongType' => [
            [...$base, HazardousMaterialsLabelsTransformerInterface::KEY_SIGNAL_WORD => 42],
            static function (HazardousMaterialsLabelsInterface $model): void {
                self::assertNull($model->getSignalWord());
            },
        ];

        yield 'signalWordIdWrongType' => [
            [...$base, HazardousMaterialsLabelsTransformerInterface::KEY_SIGNAL_WORD_ID => 42],
            static function (HazardousMaterialsLabelsInterface $model): void {
                self::assertNull($model->getSignalWordId());
            },
        ];

        yield 'statementsWrongType' => [
            [...$base, HazardousMaterialsLabelsTransformerInterface::KEY_STATEMENTS => 'x'],
            static function (HazardousMaterialsLabelsInterface $model): void {
                self::assertSame([], $model->getStatements());
            },
        ];
    }

    private function buildTransformer(): HazardousMaterialsLabelsTransformer
    {
        $this->hazardPictogram = self::createStub(HazardPictogramInterface::class);
        $this->hazardStatement = self::createStub(HazardStatementInterface::class);

        $hazardPictogramsTransformer = self::createStub(HazardPictogramsTransformerInterface::class);
        $hazardPictogramsTransformer->method('transform')->willReturn([$this->hazardPictogram]);
        $hazardStatementsTransformer = self::createStub(HazardStatementsTransformerInterface::class);
        $hazardStatementsTransformer->method('transform')->willReturn([$this->hazardStatement]);

        return new HazardousMaterialsLabelsTransformer($hazardPictogramsTransformer, $hazardStatementsTransformer);
    }
}
