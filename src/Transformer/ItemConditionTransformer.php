<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;
use function is_string;

final class ItemConditionTransformer implements ItemConditionTransformerInterface
{
    private ConditionDescriptorsTransformerInterface $conditionDescriptorsTransformer;

    public function __construct(ConditionDescriptorsTransformerInterface $conditionDescriptorsTransformer)
    {
        $this->conditionDescriptorsTransformer = $conditionDescriptorsTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        self::applyCondition($item, $data);
        self::applyConditionDescription($item, $data);
        $this->applyConditionDescriptors($item, $data);
        self::applyConditionId($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCondition(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CONDITION])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_CONDITION])) {
            return;
        }
        $item->setCondition($data[ItemTransformerInterface::KEY_CONDITION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionDescription(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CONDITION_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_CONDITION_DESCRIPTION])) {
            return;
        }
        $item->setConditionDescription($data[ItemTransformerInterface::KEY_CONDITION_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConditionDescriptors(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS])) {
            return;
        }
        $item->setConditionDescriptors($this->conditionDescriptorsTransformer->transform($data[ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionId(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CONDITION_ID])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_CONDITION_ID])) {
            return;
        }
        $item->setConditionId($data[ItemTransformerInterface::KEY_CONDITION_ID]);
    }
}
