<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CommonDescription;
use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;

use function is_array;
use function is_string;

final class CommonDescriptionTransformer implements CommonDescriptionTransformerInterface
{
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(StringsTransformerInterface $stringsTransformer)
    {
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommonDescriptionInterface
    {
        $commonDescription = new CommonDescription();

        self::applyDescription($commonDescription, $data);
        $this->applyItemIds($commonDescription, $data);

        return $commonDescription;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(CommonDescription $commonDescription, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $commonDescription->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemIds(CommonDescription $commonDescription, array $data): void
    {
        if (empty($data[self::KEY_ITEM_IDS])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_IDS])) {
            return;
        }
        $commonDescription->setItemIds($this->stringsTransformer->transform($data[self::KEY_ITEM_IDS]));
    }
}
