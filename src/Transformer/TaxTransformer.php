<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Tax;
use ChristianBrown\EBay\Browse\Model\TaxInterface;

use function is_array;
use function is_bool;
use function is_string;

final class TaxTransformer implements TaxTransformerInterface
{
    private TaxJurisdictionTransformerInterface $taxJurisdictionTransformer;

    public function __construct(TaxJurisdictionTransformerInterface $taxJurisdictionTransformer)
    {
        $this->taxJurisdictionTransformer = $taxJurisdictionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxInterface
    {
        $tax = new Tax();

        self::applyEbayCollectAndRemitTax($tax, $data);
        self::applyIncludedInPrice($tax, $data);
        self::applyShippingAndHandlingTaxed($tax, $data);
        $this->applyTaxJurisdiction($tax, $data);
        self::applyTaxPercentage($tax, $data);
        self::applyTaxType($tax, $data);

        return $tax;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEbayCollectAndRemitTax(Tax $tax, array $data): void
    {
        if (!isset($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAX])) {
            return;
        }
        if (!is_bool($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAX])) {
            return;
        }
        $tax->setEbayCollectAndRemitTax($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAX]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIncludedInPrice(Tax $tax, array $data): void
    {
        if (!isset($data[self::KEY_INCLUDED_IN_PRICE])) {
            return;
        }
        if (!is_bool($data[self::KEY_INCLUDED_IN_PRICE])) {
            return;
        }
        $tax->setIncludedInPrice($data[self::KEY_INCLUDED_IN_PRICE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingAndHandlingTaxed(Tax $tax, array $data): void
    {
        if (!isset($data[self::KEY_SHIPPING_AND_HANDLING_TAXED])) {
            return;
        }
        if (!is_bool($data[self::KEY_SHIPPING_AND_HANDLING_TAXED])) {
            return;
        }
        $tax->setShippingAndHandlingTaxed($data[self::KEY_SHIPPING_AND_HANDLING_TAXED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTaxJurisdiction(Tax $tax, array $data): void
    {
        if (empty($data[self::KEY_TAX_JURISDICTION])) {
            return;
        }
        if (!is_array($data[self::KEY_TAX_JURISDICTION])) {
            return;
        }
        $tax->setTaxJurisdiction($this->taxJurisdictionTransformer->transform($data[self::KEY_TAX_JURISDICTION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxPercentage(Tax $tax, array $data): void
    {
        if (empty($data[self::KEY_TAX_PERCENTAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_TAX_PERCENTAGE])) {
            return;
        }
        $tax->setTaxPercentage($data[self::KEY_TAX_PERCENTAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxType(Tax $tax, array $data): void
    {
        if (empty($data[self::KEY_TAX_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TAX_TYPE])) {
            return;
        }
        $tax->setTaxType($data[self::KEY_TAX_TYPE]);
    }
}
