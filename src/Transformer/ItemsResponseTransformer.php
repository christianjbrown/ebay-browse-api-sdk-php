<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemsResponse;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;

use function is_array;
use function is_int;

final class ItemsResponseTransformer implements ItemsResponseTransformerInterface
{
    private ErrorsTransformerInterface $errorsTransformer;
    private ItemsTransformerInterface $itemsTransformer;

    public function __construct(ErrorsTransformerInterface $errorsTransformer, ItemsTransformerInterface $itemsTransformer)
    {
        $this->errorsTransformer = $errorsTransformer;
        $this->itemsTransformer = $itemsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemsResponseInterface
    {
        $itemsResponse = new ItemsResponse();

        $this->applyItems($itemsResponse, $data);
        self::applyTotal($itemsResponse, $data);
        $this->applyWarnings($itemsResponse, $data);

        return $itemsResponse;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItems(ItemsResponse $itemsResponse, array $data): void
    {
        if (empty($data[self::KEY_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            return;
        }
        $itemsResponse->setItems($this->itemsTransformer->transform($data[self::KEY_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotal(ItemsResponse $itemsResponse, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_int($data[self::KEY_TOTAL])) {
            return;
        }
        $itemsResponse->setTotal($data[self::KEY_TOTAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(ItemsResponse $itemsResponse, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $itemsResponse->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
