<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\TaxInterface;

interface TaxTransformerInterface
{
    public const string KEY_EBAY_COLLECT_AND_REMIT_TAX = 'ebayCollectAndRemitTax';
    public const string KEY_INCLUDED_IN_PRICE = 'includedInPrice';
    public const string KEY_SHIPPING_AND_HANDLING_TAXED = 'shippingAndHandlingTaxed';
    public const string KEY_TAX_JURISDICTION = 'taxJurisdiction';
    public const string KEY_TAX_PERCENTAGE = 'taxPercentage';
    public const string KEY_TAX_TYPE = 'taxType';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_BOOLEAN_SPRINTF = '%s not set or not a boolean';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxInterface;
}
