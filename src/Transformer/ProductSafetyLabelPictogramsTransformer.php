<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogramInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ProductSafetyLabelPictogramsTransformer implements ProductSafetyLabelPictogramsTransformerInterface
{
    private ProductSafetyLabelPictogramTransformerInterface $productSafetyLabelPictogramTransformer;

    public function __construct(ProductSafetyLabelPictogramTransformerInterface $productSafetyLabelPictogramTransformer)
    {
        $this->productSafetyLabelPictogramTransformer = $productSafetyLabelPictogramTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ProductSafetyLabelPictogramInterface>
     */
    public function transform(array $data): array
    {
        $productSafetyLabelPictograms = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $productSafetyLabelPictogramData = $values[$i];
            if (!is_array($productSafetyLabelPictogramData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $productSafetyLabelPictograms[] = $this->productSafetyLabelPictogramTransformer->transform($productSafetyLabelPictogramData);
        }

        return $productSafetyLabelPictograms;
    }
}
