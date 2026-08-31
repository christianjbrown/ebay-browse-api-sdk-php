<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ShippingOptionsTransformer implements ShippingOptionsTransformerInterface
{
    private ShippingOptionTransformerInterface $shippingOptionTransformer;

    public function __construct(ShippingOptionTransformerInterface $shippingOptionTransformer)
    {
        $this->shippingOptionTransformer = $shippingOptionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ShippingOptionInterface>
     */
    public function transform(array $data): array
    {
        $shippingOptions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $shippingOptionData = $values[$i];
            if (!is_array($shippingOptionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $shippingOptions[] = $this->shippingOptionTransformer->transform($shippingOptionData);
        }

        return $shippingOptions;
    }
}
