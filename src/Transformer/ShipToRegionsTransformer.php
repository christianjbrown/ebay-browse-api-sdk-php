<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ShipToRegionsTransformer implements ShipToRegionsTransformerInterface
{
    private ShipToRegionTransformerInterface $shipToRegionTransformer;

    public function __construct(ShipToRegionTransformerInterface $shipToRegionTransformer)
    {
        $this->shipToRegionTransformer = $shipToRegionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ShipToRegionInterface>
     */
    public function transform(array $data): array
    {
        $shipToRegions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $shipToRegionData = $values[$i];
            if (!is_array($shipToRegionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $shipToRegions[] = $this->shipToRegionTransformer->transform($shipToRegionData);
        }

        return $shipToRegions;
    }
}
