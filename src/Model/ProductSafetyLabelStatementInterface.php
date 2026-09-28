<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ProductSafetyLabelStatementInterface
{
    public function getStatementDescription(): ?string;

    public function getStatementId(): ?string;

    public function setStatementDescription(?string $value): self;

    public function setStatementId(?string $value): self;
}
