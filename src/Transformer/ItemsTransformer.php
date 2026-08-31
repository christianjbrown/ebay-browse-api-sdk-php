<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ItemsTransformer implements ItemsTransformerInterface
{
    private ItemTransformerInterface $itemTransformer;

    public function __construct(ItemTransformerInterface $itemTransformer)
    {
        $this->itemTransformer = $itemTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ItemInterface>
     */
    public function transform(array $data): array
    {
        $items = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $itemData = $values[$i];
            if (!is_array($itemData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $items[] = $this->itemTransformer->transform($itemData);
        }

        return $items;
    }
}
