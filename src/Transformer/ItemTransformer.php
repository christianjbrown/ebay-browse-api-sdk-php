<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;

use function is_string;
use function sprintf;

final class ItemTransformer implements ItemTransformerInterface
{
    private ItemComplianceTransformerInterface $complianceTransformer;
    private ItemConditionTransformerInterface $conditionTransformer;
    private ItemDescriptionTransformerInterface $descriptionTransformer;
    private ItemFulfilmentTransformerInterface $fulfilmentTransformer;
    private ItemListingTransformerInterface $listingTransformer;
    private ItemMediaTransformerInterface $mediaTransformer;
    private ItemPricingTransformerInterface $pricingTransformer;
    private ItemProductTransformerInterface $productTransformer;

    public function __construct(ItemDescriptionTransformerInterface $descriptionTransformer, ItemConditionTransformerInterface $conditionTransformer, ItemMediaTransformerInterface $mediaTransformer, ItemPricingTransformerInterface $pricingTransformer, ItemFulfilmentTransformerInterface $fulfilmentTransformer, ItemListingTransformerInterface $listingTransformer, ItemProductTransformerInterface $productTransformer, ItemComplianceTransformerInterface $complianceTransformer)
    {
        $this->descriptionTransformer = $descriptionTransformer;
        $this->conditionTransformer = $conditionTransformer;
        $this->mediaTransformer = $mediaTransformer;
        $this->pricingTransformer = $pricingTransformer;
        $this->fulfilmentTransformer = $fulfilmentTransformer;
        $this->listingTransformer = $listingTransformer;
        $this->productTransformer = $productTransformer;
        $this->complianceTransformer = $complianceTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemInterface
    {
        if (empty($data[self::KEY_ITEM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ITEM_ID));
        }
        if (!is_string($data[self::KEY_ITEM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ITEM_ID));
        }
        $item = new Item($data[self::KEY_ITEM_ID]);

        $this->descriptionTransformer->apply($item, $data);
        $this->conditionTransformer->apply($item, $data);
        $this->mediaTransformer->apply($item, $data);
        $this->pricingTransformer->apply($item, $data);
        $this->fulfilmentTransformer->apply($item, $data);
        $this->listingTransformer->apply($item, $data);
        $this->productTransformer->apply($item, $data);
        $this->complianceTransformer->apply($item, $data);

        return $item;
    }
}
