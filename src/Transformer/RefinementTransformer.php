<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Refinement;
use ChristianBrown\EBay\Browse\Model\RefinementInterface;

use function is_array;
use function is_string;

final class RefinementTransformer implements RefinementTransformerInterface
{
    private AspectDistributionsTransformerInterface $aspectDistributionsTransformer;
    private BuyingOptionDistributionsTransformerInterface $buyingOptionDistributionsTransformer;
    private CategoryDistributionsTransformerInterface $categoryDistributionsTransformer;
    private ConditionDistributionsTransformerInterface $conditionDistributionsTransformer;

    public function __construct(AspectDistributionsTransformerInterface $aspectDistributionsTransformer, BuyingOptionDistributionsTransformerInterface $buyingOptionDistributionsTransformer, CategoryDistributionsTransformerInterface $categoryDistributionsTransformer, ConditionDistributionsTransformerInterface $conditionDistributionsTransformer)
    {
        $this->aspectDistributionsTransformer = $aspectDistributionsTransformer;
        $this->buyingOptionDistributionsTransformer = $buyingOptionDistributionsTransformer;
        $this->categoryDistributionsTransformer = $categoryDistributionsTransformer;
        $this->conditionDistributionsTransformer = $conditionDistributionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RefinementInterface
    {
        $refinement = new Refinement();

        $this->applyAspectDistributions($refinement, $data);
        $this->applyBuyingOptionDistributions($refinement, $data);
        $this->applyCategoryDistributions($refinement, $data);
        $this->applyConditionDistributions($refinement, $data);
        self::applyDominantCategoryId($refinement, $data);

        return $refinement;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAspectDistributions(Refinement $refinement, array $data): void
    {
        if (empty($data[self::KEY_ASPECT_DISTRIBUTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ASPECT_DISTRIBUTIONS])) {
            return;
        }
        $refinement->setAspectDistributions($this->aspectDistributionsTransformer->transform($data[self::KEY_ASPECT_DISTRIBUTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyingOptionDistributions(Refinement $refinement, array $data): void
    {
        if (empty($data[self::KEY_BUYING_OPTION_DISTRIBUTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_BUYING_OPTION_DISTRIBUTIONS])) {
            return;
        }
        $refinement->setBuyingOptionDistributions($this->buyingOptionDistributionsTransformer->transform($data[self::KEY_BUYING_OPTION_DISTRIBUTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCategoryDistributions(Refinement $refinement, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_DISTRIBUTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CATEGORY_DISTRIBUTIONS])) {
            return;
        }
        $refinement->setCategoryDistributions($this->categoryDistributionsTransformer->transform($data[self::KEY_CATEGORY_DISTRIBUTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConditionDistributions(Refinement $refinement, array $data): void
    {
        if (empty($data[self::KEY_CONDITION_DISTRIBUTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CONDITION_DISTRIBUTIONS])) {
            return;
        }
        $refinement->setConditionDistributions($this->conditionDistributionsTransformer->transform($data[self::KEY_CONDITION_DISTRIBUTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDominantCategoryId(Refinement $refinement, array $data): void
    {
        if (empty($data[self::KEY_DOMINANT_CATEGORY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DOMINANT_CATEGORY_ID])) {
            return;
        }
        $refinement->setDominantCategoryId($data[self::KEY_DOMINANT_CATEGORY_ID]);
    }
}
