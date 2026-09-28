<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptor;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;

use function is_array;
use function is_string;

final class ConditionDescriptorTransformer implements ConditionDescriptorTransformerInterface
{
    private ConditionDescriptorValuesTransformerInterface $conditionDescriptorValuesTransformer;

    public function __construct(ConditionDescriptorValuesTransformerInterface $conditionDescriptorValuesTransformer)
    {
        $this->conditionDescriptorValuesTransformer = $conditionDescriptorValuesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConditionDescriptorInterface
    {
        $conditionDescriptor = new ConditionDescriptor();

        self::applyName($conditionDescriptor, $data);
        $this->applyValues($conditionDescriptor, $data);

        return $conditionDescriptor;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(ConditionDescriptor $conditionDescriptor, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $conditionDescriptor->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyValues(ConditionDescriptor $conditionDescriptor, array $data): void
    {
        if (empty($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $conditionDescriptor->setValues($this->conditionDescriptorValuesTransformer->transform($data[self::KEY_VALUES]));
    }
}
