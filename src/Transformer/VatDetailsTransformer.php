<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\VatDetailInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class VatDetailsTransformer implements VatDetailsTransformerInterface
{
    private VatDetailTransformerInterface $vatDetailTransformer;

    public function __construct(VatDetailTransformerInterface $vatDetailTransformer)
    {
        $this->vatDetailTransformer = $vatDetailTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, VatDetailInterface>
     */
    public function transform(array $data): array
    {
        $vatDetails = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $vatDetailData = $values[$i];
            if (!is_array($vatDetailData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $vatDetails[] = $this->vatDetailTransformer->transform($vatDetailData);
        }

        return $vatDetails;
    }
}
