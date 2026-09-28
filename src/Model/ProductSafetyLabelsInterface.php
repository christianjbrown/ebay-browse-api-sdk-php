<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ProductSafetyLabelsInterface
{
    /**
     * @return array<int, ProductSafetyLabelPictogramInterface>
     */
    public function getPictograms(): array;

    /**
     * @return array<int, ProductSafetyLabelStatementInterface>
     */
    public function getStatements(): array;

    /**
     * @param array<int, ProductSafetyLabelPictogramInterface> $value
     */
    public function setPictograms(array $value): self;

    /**
     * @param array<int, ProductSafetyLabelStatementInterface> $value
     */
    public function setStatements(array $value): self;
}
