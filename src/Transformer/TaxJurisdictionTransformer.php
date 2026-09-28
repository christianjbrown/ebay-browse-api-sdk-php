<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\TaxJurisdiction;
use ChristianBrown\EBay\Browse\Model\TaxJurisdictionInterface;

use function is_array;
use function is_string;

final class TaxJurisdictionTransformer implements TaxJurisdictionTransformerInterface
{
    private RegionTransformerInterface $regionTransformer;

    public function __construct(RegionTransformerInterface $regionTransformer)
    {
        $this->regionTransformer = $regionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxJurisdictionInterface
    {
        $taxJurisdiction = new TaxJurisdiction();

        $this->applyRegion($taxJurisdiction, $data);
        self::applyTaxJurisdictionId($taxJurisdiction, $data);

        return $taxJurisdiction;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRegion(TaxJurisdiction $taxJurisdiction, array $data): void
    {
        if (empty($data[self::KEY_REGION])) {
            return;
        }
        if (!is_array($data[self::KEY_REGION])) {
            return;
        }
        $taxJurisdiction->setRegion($this->regionTransformer->transform($data[self::KEY_REGION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxJurisdictionId(TaxJurisdiction $taxJurisdiction, array $data): void
    {
        if (empty($data[self::KEY_TAX_JURISDICTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TAX_JURISDICTION_ID])) {
            return;
        }
        $taxJurisdiction->setTaxJurisdictionId($data[self::KEY_TAX_JURISDICTION_ID]);
    }
}
