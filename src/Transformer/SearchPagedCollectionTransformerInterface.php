<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;

interface SearchPagedCollectionTransformerInterface
{
    public const string KEY_AUTO_CORRECTIONS = 'autoCorrections';
    public const string KEY_HREF = 'href';
    public const string KEY_ITEM_SUMMARIES = 'itemSummaries';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_NEXT = 'next';
    public const string KEY_OFFSET = 'offset';
    public const string KEY_PREV = 'prev';
    public const string KEY_REFINEMENT = 'refinement';
    public const string KEY_TOTAL = 'total';
    public const string KEY_WARNINGS = 'warnings';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SearchPagedCollectionInterface;
}
