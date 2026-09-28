<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentity;
use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;

use function is_array;

final class AdditionalProductIdentityTransformer implements AdditionalProductIdentityTransformerInterface
{
    private ProductIdentitiesTransformerInterface $productIdentitiesTransformer;

    public function __construct(ProductIdentitiesTransformerInterface $productIdentitiesTransformer)
    {
        $this->productIdentitiesTransformer = $productIdentitiesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AdditionalProductIdentityInterface
    {
        $additionalProductIdentity = new AdditionalProductIdentity();

        $this->applyProductIdentity($additionalProductIdentity, $data);

        return $additionalProductIdentity;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProductIdentity(AdditionalProductIdentity $additionalProductIdentity, array $data): void
    {
        if (empty($data[self::KEY_PRODUCT_IDENTITY])) {
            return;
        }
        if (!is_array($data[self::KEY_PRODUCT_IDENTITY])) {
            return;
        }
        $additionalProductIdentity->setProductIdentity($this->productIdentitiesTransformer->transform($data[self::KEY_PRODUCT_IDENTITY]));
    }
}
