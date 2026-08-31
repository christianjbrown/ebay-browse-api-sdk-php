<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemGroup;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;

use function is_array;

final class ItemGroupTransformer implements ItemGroupTransformerInterface
{
    private CommonDescriptionsTransformerInterface $commonDescriptionsTransformer;
    private ErrorsTransformerInterface $errorsTransformer;
    private ItemsTransformerInterface $itemsTransformer;

    public function __construct(CommonDescriptionsTransformerInterface $commonDescriptionsTransformer, ErrorsTransformerInterface $errorsTransformer, ItemsTransformerInterface $itemsTransformer)
    {
        $this->commonDescriptionsTransformer = $commonDescriptionsTransformer;
        $this->errorsTransformer = $errorsTransformer;
        $this->itemsTransformer = $itemsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemGroupInterface
    {
        $itemGroup = new ItemGroup();

        $this->applyCommonDescriptions($itemGroup, $data);
        $this->applyItems($itemGroup, $data);
        $this->applyWarnings($itemGroup, $data);

        return $itemGroup;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCommonDescriptions(ItemGroup $itemGroup, array $data): void
    {
        if (empty($data[self::KEY_COMMON_DESCRIPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMON_DESCRIPTIONS])) {
            return;
        }
        $itemGroup->setCommonDescriptions($this->commonDescriptionsTransformer->transform($data[self::KEY_COMMON_DESCRIPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItems(ItemGroup $itemGroup, array $data): void
    {
        if (empty($data[self::KEY_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            return;
        }
        $itemGroup->setItems($this->itemsTransformer->transform($data[self::KEY_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(ItemGroup $itemGroup, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $itemGroup->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
