<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CategoryInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CategoriesTransformer implements CategoriesTransformerInterface
{
    private CategoryTransformerInterface $categoryTransformer;

    public function __construct(CategoryTransformerInterface $categoryTransformer)
    {
        $this->categoryTransformer = $categoryTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CategoryInterface>
     */
    public function transform(array $data): array
    {
        $categories = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $categoryData = $values[$i];
            if (!is_array($categoryData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $categories[] = $this->categoryTransformer->transform($categoryData);
        }

        return $categories;
    }
}
