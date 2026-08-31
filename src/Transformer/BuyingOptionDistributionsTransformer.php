<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class BuyingOptionDistributionsTransformer implements BuyingOptionDistributionsTransformerInterface
{
    private BuyingOptionDistributionTransformerInterface $buyingOptionDistributionTransformer;

    public function __construct(BuyingOptionDistributionTransformerInterface $buyingOptionDistributionTransformer)
    {
        $this->buyingOptionDistributionTransformer = $buyingOptionDistributionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BuyingOptionDistributionInterface>
     */
    public function transform(array $data): array
    {
        $buyingOptionDistributions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $buyingOptionDistributionData = $values[$i];
            if (!is_array($buyingOptionDistributionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $buyingOptionDistributions[] = $this->buyingOptionDistributionTransformer->transform($buyingOptionDistributionData);
        }

        return $buyingOptionDistributions;
    }
}
