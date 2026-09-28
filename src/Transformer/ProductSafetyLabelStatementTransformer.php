<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatement;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatementInterface;

use function is_string;

final class ProductSafetyLabelStatementTransformer implements ProductSafetyLabelStatementTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductSafetyLabelStatementInterface
    {
        $productSafetyLabelStatement = new ProductSafetyLabelStatement();

        self::applyStatementDescription($productSafetyLabelStatement, $data);
        self::applyStatementId($productSafetyLabelStatement, $data);

        return $productSafetyLabelStatement;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatementDescription(ProductSafetyLabelStatement $productSafetyLabelStatement, array $data): void
    {
        if (empty($data[self::KEY_STATEMENT_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_STATEMENT_DESCRIPTION])) {
            return;
        }
        $productSafetyLabelStatement->setStatementDescription($data[self::KEY_STATEMENT_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatementId(ProductSafetyLabelStatement $productSafetyLabelStatement, array $data): void
    {
        if (empty($data[self::KEY_STATEMENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_STATEMENT_ID])) {
            return;
        }
        $productSafetyLabelStatement->setStatementId($data[self::KEY_STATEMENT_ID]);
    }
}
