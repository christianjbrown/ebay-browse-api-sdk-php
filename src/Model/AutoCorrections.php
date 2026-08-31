<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AutoCorrections implements AutoCorrectionsInterface
{
    private ?string $q = null;

    public function getQ(): ?string
    {
        return $this->q;
    }

    public function setQ(?string $value): AutoCorrectionsInterface
    {
        $this->q = $value;

        return $this;
    }
}
