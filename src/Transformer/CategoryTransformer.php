<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Category;
use ChristianBrown\EBay\Browse\Model\CategoryInterface;

use function is_string;
use function sprintf;

final class CategoryTransformer implements CategoryTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CategoryInterface
    {
        if (empty($data[self::KEY_CATEGORY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CATEGORY_ID));
        }
        if (!is_string($data[self::KEY_CATEGORY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CATEGORY_ID));
        }
        $category = new Category($data[self::KEY_CATEGORY_ID]);

        self::applyCategoryName($category, $data);

        return $category;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryName(Category $category, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY_NAME])) {
            return;
        }
        $category->setCategoryName($data[self::KEY_CATEGORY_NAME]);
    }
}
