<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AutoCorrectionsInterface;

interface AutoCorrectionsTransformerInterface
{
    public const string KEY_Q = 'q';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutoCorrectionsInterface;
}
