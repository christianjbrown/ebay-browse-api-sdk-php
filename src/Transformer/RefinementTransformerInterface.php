<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\RefinementInterface;

interface RefinementTransformerInterface
{
    public const string KEY_ASPECT_DISTRIBUTIONS = 'aspectDistributions';
    public const string KEY_BUYING_OPTION_DISTRIBUTIONS = 'buyingOptionDistributions';
    public const string KEY_CATEGORY_DISTRIBUTIONS = 'categoryDistributions';
    public const string KEY_CONDITION_DISTRIBUTIONS = 'conditionDistributions';
    public const string KEY_DOMINANT_CATEGORY_ID = 'dominantCategoryId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RefinementInterface;
}
