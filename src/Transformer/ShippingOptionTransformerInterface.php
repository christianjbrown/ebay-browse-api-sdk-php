<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;

interface ShippingOptionTransformerInterface
{
    public const string KEY_ADDITIONAL_SHIPPING_COST_PER_UNIT = 'additionalShippingCostPerUnit';
    public const string KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE = 'cutOffDateUsedForEstimate';
    public const string KEY_FULFILLED_THROUGH = 'fulfilledThrough';
    public const string KEY_GUARANTEED_DELIVERY = 'guaranteedDelivery';
    public const string KEY_IMPORT_CHARGES = 'importCharges';
    public const string KEY_MAX_ESTIMATED_DELIVERY_DATE = 'maxEstimatedDeliveryDate';
    public const string KEY_MIN_ESTIMATED_DELIVERY_DATE = 'minEstimatedDeliveryDate';
    public const string KEY_QUANTITY_USED_FOR_ESTIMATE = 'quantityUsedForEstimate';
    public const string KEY_SHIP_TO_LOCATION_USED_FOR_ESTIMATE = 'shipToLocationUsedForEstimate';
    public const string KEY_SHIPPING_CARRIER_CODE = 'shippingCarrierCode';
    public const string KEY_SHIPPING_COST = 'shippingCost';
    public const string KEY_SHIPPING_COST_TYPE = 'shippingCostType';
    public const string KEY_SHIPPING_SERVICE_CODE = 'shippingServiceCode';
    public const string KEY_TRADEMARK_SYMBOL = 'trademarkSymbol';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_BOOLEAN_SPRINTF = '%s not set or not a boolean';
    public const string UNEXPECTED_INTEGER_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingOptionInterface;
}
