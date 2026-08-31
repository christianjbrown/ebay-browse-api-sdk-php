<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AutoCorrectionsInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;
use ChristianBrown\EBay\Browse\Model\RefinementInterface;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollection;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformer;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SearchPagedCollection::class)]
#[CoversClass(SearchPagedCollectionTransformer::class)]
final class SearchPagedCollectionTransformerTest extends TestCase
{
    private ?AutoCorrectionsInterface $autoCorrections = null;
    private ?ErrorInterface $error = null;
    private ?ItemSummaryInterface $itemSummary = null;
    private ?RefinementInterface $refinement = null;

    public function testTransform(): void
    {
        $data = [
            SearchPagedCollectionTransformerInterface::KEY_AUTO_CORRECTIONS => ['raw_autoCorrections'],
            SearchPagedCollectionTransformerInterface::KEY_HREF => 'v_1',
            SearchPagedCollectionTransformerInterface::KEY_ITEM_SUMMARIES => ['raw_itemSummaries'],
            SearchPagedCollectionTransformerInterface::KEY_LIMIT => 103,
            SearchPagedCollectionTransformerInterface::KEY_NEXT => 'v_4',
            SearchPagedCollectionTransformerInterface::KEY_OFFSET => 105,
            SearchPagedCollectionTransformerInterface::KEY_PREV => 'v_6',
            SearchPagedCollectionTransformerInterface::KEY_REFINEMENT => ['raw_refinement'],
            SearchPagedCollectionTransformerInterface::KEY_TOTAL => 108,
            SearchPagedCollectionTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->autoCorrections, $actual->getAutoCorrections());
        self::assertSame('v_1', $actual->getHref());
        self::assertSame([$this->itemSummary], $actual->getItemSummaries());
        self::assertSame(103, $actual->getLimit());
        self::assertSame('v_4', $actual->getNext());
        self::assertSame(105, $actual->getOffset());
        self::assertSame('v_6', $actual->getPrev());
        self::assertSame($this->refinement, $actual->getRefinement());
        self::assertSame(108, $actual->getTotal());
        self::assertSame([$this->error], $actual->getWarnings());
    }

    /**
     * @param array<string, mixed>                          $data
     * @param Closure(SearchPagedCollectionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(SearchPagedCollectionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getAutoCorrections());
                self::assertNull($model->getHref());
                self::assertSame([], $model->getItemSummaries());
                self::assertNull($model->getLimit());
                self::assertNull($model->getNext());
                self::assertNull($model->getOffset());
                self::assertNull($model->getPrev());
                self::assertNull($model->getRefinement());
                self::assertNull($model->getTotal());
                self::assertSame([], $model->getWarnings());
            },
        ];

        yield 'autoCorrectionsWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_AUTO_CORRECTIONS => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getAutoCorrections());
            },
        ];

        yield 'hrefWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_HREF => 42],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getHref());
            },
        ];

        yield 'itemSummariesWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_ITEM_SUMMARIES => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertSame([], $model->getItemSummaries());
            },
        ];

        yield 'limitWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_LIMIT => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getLimit());
            },
        ];

        yield 'limitZero' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_LIMIT => 0],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertSame(0, $model->getLimit());
            },
        ];

        yield 'nextWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_NEXT => 42],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getNext());
            },
        ];

        yield 'offsetWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_OFFSET => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getOffset());
            },
        ];

        yield 'offsetZero' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_OFFSET => 0],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertSame(0, $model->getOffset());
            },
        ];

        yield 'prevWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_PREV => 42],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getPrev());
            },
        ];

        yield 'refinementWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_REFINEMENT => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getRefinement());
            },
        ];

        yield 'totalWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_TOTAL => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertNull($model->getTotal());
            },
        ];

        yield 'totalZero' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_TOTAL => 0],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertSame(0, $model->getTotal());
            },
        ];

        yield 'warningsWrongType' => [
            [...$base, SearchPagedCollectionTransformerInterface::KEY_WARNINGS => 'x'],
            static function (SearchPagedCollectionInterface $model): void {
                self::assertSame([], $model->getWarnings());
            },
        ];
    }

    private function buildTransformer(): SearchPagedCollectionTransformer
    {
        $this->autoCorrections = self::createStub(AutoCorrectionsInterface::class);
        $this->error = self::createStub(ErrorInterface::class);
        $this->itemSummary = self::createStub(ItemSummaryInterface::class);
        $this->refinement = self::createStub(RefinementInterface::class);

        $autoCorrectionsTransformer = self::createStub(AutoCorrectionsTransformerInterface::class);
        $autoCorrectionsTransformer->method('transform')->willReturn($this->autoCorrections);
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);
        $itemSummariesTransformer = self::createStub(ItemSummariesTransformerInterface::class);
        $itemSummariesTransformer->method('transform')->willReturn([$this->itemSummary]);
        $refinementTransformer = self::createStub(RefinementTransformerInterface::class);
        $refinementTransformer->method('transform')->willReturn($this->refinement);

        return new SearchPagedCollectionTransformer($autoCorrectionsTransformer, $errorsTransformer, $itemSummariesTransformer, $refinementTransformer);
    }
}
