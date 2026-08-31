<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CategoryDistribution;
use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;

use function is_int;
use function is_string;

final class CategoryDistributionTransformer implements CategoryDistributionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CategoryDistributionInterface
    {
        $categoryDistribution = new CategoryDistribution();

        self::applyCategoryId($categoryDistribution, $data);
        self::applyCategoryName($categoryDistribution, $data);
        self::applyMatchCount($categoryDistribution, $data);
        self::applyRefinementHref($categoryDistribution, $data);

        return $categoryDistribution;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryId(CategoryDistribution $categoryDistribution, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY_ID])) {
            return;
        }
        $categoryDistribution->setCategoryId($data[self::KEY_CATEGORY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryName(CategoryDistribution $categoryDistribution, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY_NAME])) {
            return;
        }
        $categoryDistribution->setCategoryName($data[self::KEY_CATEGORY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatchCount(CategoryDistribution $categoryDistribution, array $data): void
    {
        if (!isset($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        $categoryDistribution->setMatchCount($data[self::KEY_MATCH_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefinementHref(CategoryDistribution $categoryDistribution, array $data): void
    {
        if (empty($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        $categoryDistribution->setRefinementHref($data[self::KEY_REFINEMENT_HREF]);
    }
}
