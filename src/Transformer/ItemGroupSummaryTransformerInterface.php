<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemGroupSummaryInterface;

interface ItemGroupSummaryTransformerInterface
{
    public const string KEY_ITEM_GROUP_ADDITIONAL_IMAGES = 'itemGroupAdditionalImages';
    public const string KEY_ITEM_GROUP_HREF = 'itemGroupHref';
    public const string KEY_ITEM_GROUP_ID = 'itemGroupId';
    public const string KEY_ITEM_GROUP_IMAGE = 'itemGroupImage';
    public const string KEY_ITEM_GROUP_TITLE = 'itemGroupTitle';
    public const string KEY_ITEM_GROUP_TYPE = 'itemGroupType';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemGroupSummaryInterface;
}
