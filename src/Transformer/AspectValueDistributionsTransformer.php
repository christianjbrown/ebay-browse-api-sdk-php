<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AspectValueDistributionsTransformer implements AspectValueDistributionsTransformerInterface
{
    private AspectValueDistributionTransformerInterface $aspectValueDistributionTransformer;

    public function __construct(AspectValueDistributionTransformerInterface $aspectValueDistributionTransformer)
    {
        $this->aspectValueDistributionTransformer = $aspectValueDistributionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AspectValueDistributionInterface>
     */
    public function transform(array $data): array
    {
        $aspectValueDistributions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $aspectValueDistributionData = $values[$i];
            if (!is_array($aspectValueDistributionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $aspectValueDistributions[] = $this->aspectValueDistributionTransformer->transform($aspectValueDistributionData);
        }

        return $aspectValueDistributions;
    }
}
