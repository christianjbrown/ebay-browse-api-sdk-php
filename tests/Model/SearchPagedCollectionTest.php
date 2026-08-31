<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AutoCorrectionsInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;
use ChristianBrown\EBay\Browse\Model\RefinementInterface;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SearchPagedCollection::class)]
final class SearchPagedCollectionTest extends TestCase
{
    public function test(): void
    {
        $autoCorrections = self::createStub(AutoCorrectionsInterface::class);
        $itemSummaries = [self::createStub(ItemSummaryInterface::class)];
        $refinement = self::createStub(RefinementInterface::class);
        $warnings = [self::createStub(ErrorInterface::class)];

        $searchPagedCollection = new SearchPagedCollection();
        self::assertNull($searchPagedCollection->getAutoCorrections());
        self::assertNull($searchPagedCollection->getHref());
        self::assertSame([], $searchPagedCollection->getItemSummaries());
        self::assertNull($searchPagedCollection->getLimit());
        self::assertNull($searchPagedCollection->getNext());
        self::assertNull($searchPagedCollection->getOffset());
        self::assertNull($searchPagedCollection->getPrev());
        self::assertNull($searchPagedCollection->getRefinement());
        self::assertNull($searchPagedCollection->getTotal());
        self::assertSame([], $searchPagedCollection->getWarnings());

        self::assertSame($searchPagedCollection, $searchPagedCollection->setAutoCorrections($autoCorrections));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setHref('v_52'));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setItemSummaries($itemSummaries));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setLimit(154));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setNext('v_55'));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setOffset(156));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setPrev('v_57'));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setRefinement($refinement));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setTotal(159));
        self::assertSame($searchPagedCollection, $searchPagedCollection->setWarnings($warnings));

        self::assertSame($autoCorrections, $searchPagedCollection->getAutoCorrections());
        self::assertSame('v_52', $searchPagedCollection->getHref());
        self::assertSame($itemSummaries, $searchPagedCollection->getItemSummaries());
        self::assertSame(154, $searchPagedCollection->getLimit());
        self::assertSame('v_55', $searchPagedCollection->getNext());
        self::assertSame(156, $searchPagedCollection->getOffset());
        self::assertSame('v_57', $searchPagedCollection->getPrev());
        self::assertSame($refinement, $searchPagedCollection->getRefinement());
        self::assertSame(159, $searchPagedCollection->getTotal());
        self::assertSame($warnings, $searchPagedCollection->getWarnings());
    }
}
