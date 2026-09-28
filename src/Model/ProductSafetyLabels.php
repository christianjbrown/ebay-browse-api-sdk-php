<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ProductSafetyLabels implements ProductSafetyLabelsInterface
{
    /**
     * @var array<int, ProductSafetyLabelPictogramInterface>
     */
    private array $pictograms = [];

    /**
     * @var array<int, ProductSafetyLabelStatementInterface>
     */
    private array $statements = [];

    /**
     * @return array<int, ProductSafetyLabelPictogramInterface>
     */
    public function getPictograms(): array
    {
        return $this->pictograms;
    }

    /**
     * @return array<int, ProductSafetyLabelStatementInterface>
     */
    public function getStatements(): array
    {
        return $this->statements;
    }

    /**
     * @param array<int, ProductSafetyLabelPictogramInterface> $value
     */
    public function setPictograms(array $value): ProductSafetyLabelsInterface
    {
        $this->pictograms = $value;

        return $this;
    }

    /**
     * @param array<int, ProductSafetyLabelStatementInterface> $value
     */
    public function setStatements(array $value): ProductSafetyLabelsInterface
    {
        $this->statements = $value;

        return $this;
    }
}
