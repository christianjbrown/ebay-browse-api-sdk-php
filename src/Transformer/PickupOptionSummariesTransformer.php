<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\PickupOptionSummaryInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PickupOptionSummariesTransformer implements PickupOptionSummariesTransformerInterface
{
    private PickupOptionSummaryTransformerInterface $pickupOptionSummaryTransformer;

    public function __construct(PickupOptionSummaryTransformerInterface $pickupOptionSummaryTransformer)
    {
        $this->pickupOptionSummaryTransformer = $pickupOptionSummaryTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PickupOptionSummaryInterface>
     */
    public function transform(array $data): array
    {
        $pickupOptionSummaries = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $pickupOptionSummaryData = $values[$i];
            if (!is_array($pickupOptionSummaryData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $pickupOptionSummaries[] = $this->pickupOptionSummaryTransformer->transform($pickupOptionSummaryData);
        }

        return $pickupOptionSummaries;
    }
}
