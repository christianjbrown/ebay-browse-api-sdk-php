<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;

interface CategoryDistributionTransformerInterface
{
    public const string KEY_CATEGORY_ID = 'categoryId';
    public const string KEY_CATEGORY_NAME = 'categoryName';
    public const string KEY_MATCH_COUNT = 'matchCount';
    public const string KEY_REFINEMENT_HREF = 'refinementHref';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CategoryDistributionInterface;
}
