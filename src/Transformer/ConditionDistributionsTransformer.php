<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ConditionDistributionsTransformer implements ConditionDistributionsTransformerInterface
{
    private ConditionDistributionTransformerInterface $conditionDistributionTransformer;

    public function __construct(ConditionDistributionTransformerInterface $conditionDistributionTransformer)
    {
        $this->conditionDistributionTransformer = $conditionDistributionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ConditionDistributionInterface>
     */
    public function transform(array $data): array
    {
        $conditionDistributions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $conditionDistributionData = $values[$i];
            if (!is_array($conditionDistributionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $conditionDistributions[] = $this->conditionDistributionTransformer->transform($conditionDistributionData);
        }

        return $conditionDistributions;
    }
}
