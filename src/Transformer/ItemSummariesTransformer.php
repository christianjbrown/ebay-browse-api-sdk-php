<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ItemSummariesTransformer implements ItemSummariesTransformerInterface
{
    private ItemSummaryTransformerInterface $itemSummaryTransformer;

    public function __construct(ItemSummaryTransformerInterface $itemSummaryTransformer)
    {
        $this->itemSummaryTransformer = $itemSummaryTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ItemSummaryInterface>
     */
    public function transform(array $data): array
    {
        $itemSummaries = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $itemSummaryData = $values[$i];
            if (!is_array($itemSummaryData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $itemSummaries[] = $this->itemSummaryTransformer->transform($itemSummaryData);
        }

        return $itemSummaries;
    }
}
