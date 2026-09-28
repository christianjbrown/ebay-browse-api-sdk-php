<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Aspect;
use ChristianBrown\EBay\Browse\Model\AspectInterface;

use function is_array;
use function is_string;

final class AspectTransformer implements AspectTransformerInterface
{
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(StringsTransformerInterface $stringsTransformer)
    {
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectInterface
    {
        $aspect = new Aspect();

        self::applyLocalizedName($aspect, $data);
        $this->applyLocalizedValues($aspect, $data);

        return $aspect;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalizedName(Aspect $aspect, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALIZED_NAME])) {
            return;
        }
        $aspect->setLocalizedName($data[self::KEY_LOCALIZED_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLocalizedValues(Aspect $aspect, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCALIZED_VALUES])) {
            return;
        }
        $aspect->setLocalizedValues($this->stringsTransformer->transform($data[self::KEY_LOCALIZED_VALUES]));
    }
}
