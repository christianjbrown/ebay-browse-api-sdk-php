<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ConditionDescriptorValuesTransformer implements ConditionDescriptorValuesTransformerInterface
{
    private ConditionDescriptorValueTransformerInterface $conditionDescriptorValueTransformer;

    public function __construct(ConditionDescriptorValueTransformerInterface $conditionDescriptorValueTransformer)
    {
        $this->conditionDescriptorValueTransformer = $conditionDescriptorValueTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ConditionDescriptorValueInterface>
     */
    public function transform(array $data): array
    {
        $conditionDescriptorValues = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $conditionDescriptorValueData = $values[$i];
            if (!is_array($conditionDescriptorValueData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $conditionDescriptorValues[] = $this->conditionDescriptorValueTransformer->transform($conditionDescriptorValueData);
        }

        return $conditionDescriptorValues;
    }
}
