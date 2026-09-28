<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class HazardStatement implements HazardStatementInterface
{
    private ?string $statementDescription = null;
    private ?string $statementId = null;

    public function getStatementDescription(): ?string
    {
        return $this->statementDescription;
    }

    public function getStatementId(): ?string
    {
        return $this->statementId;
    }

    public function setStatementDescription(?string $value): HazardStatementInterface
    {
        $this->statementDescription = $value;

        return $this;
    }

    public function setStatementId(?string $value): HazardStatementInterface
    {
        $this->statementId = $value;

        return $this;
    }
}
