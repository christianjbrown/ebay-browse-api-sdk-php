<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AutoCorrections;
use ChristianBrown\EBay\Browse\Model\AutoCorrectionsInterface;

use function is_string;

final class AutoCorrectionsTransformer implements AutoCorrectionsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutoCorrectionsInterface
    {
        $autoCorrections = new AutoCorrections();

        self::applyQ($autoCorrections, $data);

        return $autoCorrections;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyQ(AutoCorrections $autoCorrections, array $data): void
    {
        if (empty($data[self::KEY_Q])) {
            return;
        }
        if (!is_string($data[self::KEY_Q])) {
            return;
        }
        $autoCorrections->setQ($data[self::KEY_Q]);
    }
}
