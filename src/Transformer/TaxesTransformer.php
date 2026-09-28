<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TaxInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class TaxesTransformer implements TaxesTransformerInterface
{
    private TaxTransformerInterface $taxTransformer;

    public function __construct(TaxTransformerInterface $taxTransformer)
    {
        $this->taxTransformer = $taxTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TaxInterface>
     */
    public function transform(array $data): array
    {
        $taxes = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $taxData = $values[$i];
            if (!is_array($taxData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $taxes[] = $this->taxTransformer->transform($taxData);
        }

        return $taxes;
    }
}
