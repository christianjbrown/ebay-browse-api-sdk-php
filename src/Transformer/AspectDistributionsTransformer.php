<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AspectDistributionsTransformer implements AspectDistributionsTransformerInterface
{
    private AspectDistributionTransformerInterface $aspectDistributionTransformer;

    public function __construct(AspectDistributionTransformerInterface $aspectDistributionTransformer)
    {
        $this->aspectDistributionTransformer = $aspectDistributionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AspectDistributionInterface>
     */
    public function transform(array $data): array
    {
        $aspectDistributions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $aspectDistributionData = $values[$i];
            if (!is_array($aspectDistributionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $aspectDistributions[] = $this->aspectDistributionTransformer->transform($aspectDistributionData);
        }

        return $aspectDistributions;
    }
}
