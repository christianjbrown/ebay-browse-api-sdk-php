<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface HazardousMaterialsLabelsInterface
{
    public function getAdditionalInformation(): ?string;

    /**
     * @return array<int, HazardPictogramInterface>
     */
    public function getPictograms(): array;

    public function getSignalWord(): ?string;

    public function getSignalWordId(): ?string;

    /**
     * @return array<int, HazardStatementInterface>
     */
    public function getStatements(): array;

    public function setAdditionalInformation(?string $value): self;

    /**
     * @param array<int, HazardPictogramInterface> $value
     */
    public function setPictograms(array $value): self;

    public function setSignalWord(?string $value): self;

    public function setSignalWordId(?string $value): self;

    /**
     * @param array<int, HazardStatementInterface> $value
     */
    public function setStatements(array $value): self;
}
