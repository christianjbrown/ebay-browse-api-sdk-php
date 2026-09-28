<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AdditionalProductIdentityInterface
{
    /**
     * @return array<int, ProductIdentityInterface>
     */
    public function getProductIdentity(): array;

    /**
     * @param array<int, ProductIdentityInterface> $value
     */
    public function setProductIdentity(array $value): self;
}
