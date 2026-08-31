<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SearchPagedCollection;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;

use function is_array;
use function is_int;
use function is_string;

final class SearchPagedCollectionTransformer implements SearchPagedCollectionTransformerInterface
{
    private AutoCorrectionsTransformerInterface $autoCorrectionsTransformer;
    private ErrorsTransformerInterface $errorsTransformer;
    private ItemSummariesTransformerInterface $itemSummariesTransformer;
    private RefinementTransformerInterface $refinementTransformer;

    public function __construct(AutoCorrectionsTransformerInterface $autoCorrectionsTransformer, ErrorsTransformerInterface $errorsTransformer, ItemSummariesTransformerInterface $itemSummariesTransformer, RefinementTransformerInterface $refinementTransformer)
    {
        $this->autoCorrectionsTransformer = $autoCorrectionsTransformer;
        $this->errorsTransformer = $errorsTransformer;
        $this->itemSummariesTransformer = $itemSummariesTransformer;
        $this->refinementTransformer = $refinementTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SearchPagedCollectionInterface
    {
        $searchPagedCollection = new SearchPagedCollection();

        $this->applyAutoCorrections($searchPagedCollection, $data);
        self::applyHref($searchPagedCollection, $data);
        $this->applyItemSummaries($searchPagedCollection, $data);
        self::applyLimit($searchPagedCollection, $data);
        self::applyNext($searchPagedCollection, $data);
        self::applyOffset($searchPagedCollection, $data);
        self::applyPrev($searchPagedCollection, $data);
        $this->applyRefinement($searchPagedCollection, $data);
        self::applyTotal($searchPagedCollection, $data);
        $this->applyWarnings($searchPagedCollection, $data);

        return $searchPagedCollection;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAutoCorrections(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_AUTO_CORRECTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_AUTO_CORRECTIONS])) {
            return;
        }
        $searchPagedCollection->setAutoCorrections($this->autoCorrectionsTransformer->transform($data[self::KEY_AUTO_CORRECTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHref(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_HREF])) {
            return;
        }
        $searchPagedCollection->setHref($data[self::KEY_HREF]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemSummaries(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_ITEM_SUMMARIES])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_SUMMARIES])) {
            return;
        }
        $searchPagedCollection->setItemSummaries($this->itemSummariesTransformer->transform($data[self::KEY_ITEM_SUMMARIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLimit(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_LIMIT])) {
            return;
        }
        if (!is_int($data[self::KEY_LIMIT])) {
            return;
        }
        $searchPagedCollection->setLimit($data[self::KEY_LIMIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNext(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_NEXT])) {
            return;
        }
        if (!is_string($data[self::KEY_NEXT])) {
            return;
        }
        $searchPagedCollection->setNext($data[self::KEY_NEXT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOffset(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_OFFSET])) {
            return;
        }
        if (!is_int($data[self::KEY_OFFSET])) {
            return;
        }
        $searchPagedCollection->setOffset($data[self::KEY_OFFSET]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPrev(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_PREV])) {
            return;
        }
        if (!is_string($data[self::KEY_PREV])) {
            return;
        }
        $searchPagedCollection->setPrev($data[self::KEY_PREV]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRefinement(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_REFINEMENT])) {
            return;
        }
        if (!is_array($data[self::KEY_REFINEMENT])) {
            return;
        }
        $searchPagedCollection->setRefinement($this->refinementTransformer->transform($data[self::KEY_REFINEMENT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotal(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_int($data[self::KEY_TOTAL])) {
            return;
        }
        $searchPagedCollection->setTotal($data[self::KEY_TOTAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(SearchPagedCollection $searchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $searchPagedCollection->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
