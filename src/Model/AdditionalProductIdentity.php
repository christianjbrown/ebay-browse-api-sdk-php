<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AdditionalProductIdentity implements AdditionalProductIdentityInterface
{
    /**
     * @var array<int, ProductIdentityInterface>
     */
    private array $productIdentity = [];

    /**
     * @return array<int, ProductIdentityInterface>
     */
    public function getProductIdentity(): array
    {
        return $this->productIdentity;
    }

    /**
     * @param array<int, ProductIdentityInterface> $value
     */
    public function setProductIdentity(array $value): AdditionalProductIdentityInterface
    {
        $this->productIdentity = $value;

        return $this;
    }
}
