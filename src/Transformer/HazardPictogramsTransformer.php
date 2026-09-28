<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class HazardPictogramsTransformer implements HazardPictogramsTransformerInterface
{
    private HazardPictogramTransformerInterface $hazardPictogramTransformer;

    public function __construct(HazardPictogramTransformerInterface $hazardPictogramTransformer)
    {
        $this->hazardPictogramTransformer = $hazardPictogramTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HazardPictogramInterface>
     */
    public function transform(array $data): array
    {
        $hazardPictograms = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $hazardPictogramData = $values[$i];
            if (!is_array($hazardPictogramData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $hazardPictograms[] = $this->hazardPictogramTransformer->transform($hazardPictogramData);
        }

        return $hazardPictograms;
    }
}
