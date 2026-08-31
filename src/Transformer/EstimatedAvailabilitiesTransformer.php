<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class EstimatedAvailabilitiesTransformer implements EstimatedAvailabilitiesTransformerInterface
{
    private EstimatedAvailabilityTransformerInterface $estimatedAvailabilityTransformer;

    public function __construct(EstimatedAvailabilityTransformerInterface $estimatedAvailabilityTransformer)
    {
        $this->estimatedAvailabilityTransformer = $estimatedAvailabilityTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EstimatedAvailabilityInterface>
     */
    public function transform(array $data): array
    {
        $estimatedAvailabilities = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $estimatedAvailabilityData = $values[$i];
            if (!is_array($estimatedAvailabilityData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $estimatedAvailabilities[] = $this->estimatedAvailabilityTransformer->transform($estimatedAvailabilityData);
        }

        return $estimatedAvailabilities;
    }
}
