<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CategoryDistributionsTransformer implements CategoryDistributionsTransformerInterface
{
    private CategoryDistributionTransformerInterface $categoryDistributionTransformer;

    public function __construct(CategoryDistributionTransformerInterface $categoryDistributionTransformer)
    {
        $this->categoryDistributionTransformer = $categoryDistributionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CategoryDistributionInterface>
     */
    public function transform(array $data): array
    {
        $categoryDistributions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $categoryDistributionData = $values[$i];
            if (!is_array($categoryDistributionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $categoryDistributions[] = $this->categoryDistributionTransformer->transform($categoryDistributionData);
        }

        return $categoryDistributions;
    }
}
