<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\BuyingOptionDistribution;
use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;

use function is_int;
use function is_string;

final class BuyingOptionDistributionTransformer implements BuyingOptionDistributionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BuyingOptionDistributionInterface
    {
        $buyingOptionDistribution = new BuyingOptionDistribution();

        self::applyBuyingOption($buyingOptionDistribution, $data);
        self::applyMatchCount($buyingOptionDistribution, $data);
        self::applyRefinementHref($buyingOptionDistribution, $data);

        return $buyingOptionDistribution;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBuyingOption(BuyingOptionDistribution $buyingOptionDistribution, array $data): void
    {
        if (empty($data[self::KEY_BUYING_OPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_BUYING_OPTION])) {
            return;
        }
        $buyingOptionDistribution->setBuyingOption($data[self::KEY_BUYING_OPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatchCount(BuyingOptionDistribution $buyingOptionDistribution, array $data): void
    {
        if (!isset($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        $buyingOptionDistribution->setMatchCount($data[self::KEY_MATCH_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefinementHref(BuyingOptionDistribution $buyingOptionDistribution, array $data): void
    {
        if (empty($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        $buyingOptionDistribution->setRefinementHref($data[self::KEY_REFINEMENT_HREF]);
    }
}
