<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabels;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelsInterface;

use function is_array;

final class ProductSafetyLabelsTransformer implements ProductSafetyLabelsTransformerInterface
{
    private ProductSafetyLabelPictogramsTransformerInterface $productSafetyLabelPictogramsTransformer;
    private ProductSafetyLabelStatementsTransformerInterface $productSafetyLabelStatementsTransformer;

    public function __construct(ProductSafetyLabelPictogramsTransformerInterface $productSafetyLabelPictogramsTransformer, ProductSafetyLabelStatementsTransformerInterface $productSafetyLabelStatementsTransformer)
    {
        $this->productSafetyLabelPictogramsTransformer = $productSafetyLabelPictogramsTransformer;
        $this->productSafetyLabelStatementsTransformer = $productSafetyLabelStatementsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductSafetyLabelsInterface
    {
        $productSafetyLabels = new ProductSafetyLabels();

        $this->applyPictograms($productSafetyLabels, $data);
        $this->applyStatements($productSafetyLabels, $data);

        return $productSafetyLabels;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPictograms(ProductSafetyLabels $productSafetyLabels, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAMS])) {
            return;
        }
        if (!is_array($data[self::KEY_PICTOGRAMS])) {
            return;
        }
        $productSafetyLabels->setPictograms($this->productSafetyLabelPictogramsTransformer->transform($data[self::KEY_PICTOGRAMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStatements(ProductSafetyLabels $productSafetyLabels, array $data): void
    {
        if (empty($data[self::KEY_STATEMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_STATEMENTS])) {
            return;
        }
        $productSafetyLabels->setStatements($this->productSafetyLabelStatementsTransformer->transform($data[self::KEY_STATEMENTS]));
    }
}
