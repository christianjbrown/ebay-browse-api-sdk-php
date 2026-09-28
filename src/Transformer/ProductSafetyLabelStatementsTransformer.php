<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatementInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ProductSafetyLabelStatementsTransformer implements ProductSafetyLabelStatementsTransformerInterface
{
    private ProductSafetyLabelStatementTransformerInterface $productSafetyLabelStatementTransformer;

    public function __construct(ProductSafetyLabelStatementTransformerInterface $productSafetyLabelStatementTransformer)
    {
        $this->productSafetyLabelStatementTransformer = $productSafetyLabelStatementTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ProductSafetyLabelStatementInterface>
     */
    public function transform(array $data): array
    {
        $productSafetyLabelStatements = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $productSafetyLabelStatementData = $values[$i];
            if (!is_array($productSafetyLabelStatementData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $productSafetyLabelStatements[] = $this->productSafetyLabelStatementTransformer->transform($productSafetyLabelStatementData);
        }

        return $productSafetyLabelStatements;
    }
}
