<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class HazardousMaterialsLabels implements HazardousMaterialsLabelsInterface
{
    private ?string $additionalInformation = null;

    /**
     * @var array<int, HazardPictogramInterface>
     */
    private array $pictograms = [];
    private ?string $signalWord = null;
    private ?string $signalWordId = null;

    /**
     * @var array<int, HazardStatementInterface>
     */
    private array $statements = [];

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @return array<int, HazardPictogramInterface>
     */
    public function getPictograms(): array
    {
        return $this->pictograms;
    }

    public function getSignalWord(): ?string
    {
        return $this->signalWord;
    }

    public function getSignalWordId(): ?string
    {
        return $this->signalWordId;
    }

    /**
     * @return array<int, HazardStatementInterface>
     */
    public function getStatements(): array
    {
        return $this->statements;
    }

    public function setAdditionalInformation(?string $value): HazardousMaterialsLabelsInterface
    {
        $this->additionalInformation = $value;

        return $this;
    }

    /**
     * @param array<int, HazardPictogramInterface> $value
     */
    public function setPictograms(array $value): HazardousMaterialsLabelsInterface
    {
        $this->pictograms = $value;

        return $this;
    }

    public function setSignalWord(?string $value): HazardousMaterialsLabelsInterface
    {
        $this->signalWord = $value;

        return $this;
    }

    public function setSignalWordId(?string $value): HazardousMaterialsLabelsInterface
    {
        $this->signalWordId = $value;

        return $this;
    }

    /**
     * @param array<int, HazardStatementInterface> $value
     */
    public function setStatements(array $value): HazardousMaterialsLabelsInterface
    {
        $this->statements = $value;

        return $this;
    }
}
