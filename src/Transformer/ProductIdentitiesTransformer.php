<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ProductIdentityInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ProductIdentitiesTransformer implements ProductIdentitiesTransformerInterface
{
    private ProductIdentityTransformerInterface $productIdentityTransformer;

    public function __construct(ProductIdentityTransformerInterface $productIdentityTransformer)
    {
        $this->productIdentityTransformer = $productIdentityTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ProductIdentityInterface>
     */
    public function transform(array $data): array
    {
        $productIdentities = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $productIdentityData = $values[$i];
            if (!is_array($productIdentityData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $productIdentities[] = $this->productIdentityTransformer->transform($productIdentityData);
        }

        return $productIdentities;
    }
}
