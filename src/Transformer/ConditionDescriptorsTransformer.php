<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ConditionDescriptorsTransformer implements ConditionDescriptorsTransformerInterface
{
    private ConditionDescriptorTransformerInterface $conditionDescriptorTransformer;

    public function __construct(ConditionDescriptorTransformerInterface $conditionDescriptorTransformer)
    {
        $this->conditionDescriptorTransformer = $conditionDescriptorTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ConditionDescriptorInterface>
     */
    public function transform(array $data): array
    {
        $conditionDescriptors = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $conditionDescriptorData = $values[$i];
            if (!is_array($conditionDescriptorData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $conditionDescriptors[] = $this->conditionDescriptorTransformer->transform($conditionDescriptorData);
        }

        return $conditionDescriptors;
    }
}
