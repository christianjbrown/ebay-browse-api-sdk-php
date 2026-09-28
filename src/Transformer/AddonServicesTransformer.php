<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AddonServicesTransformer implements AddonServicesTransformerInterface
{
    private AddonServiceTransformerInterface $addonServiceTransformer;

    public function __construct(AddonServiceTransformerInterface $addonServiceTransformer)
    {
        $this->addonServiceTransformer = $addonServiceTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AddonServiceInterface>
     */
    public function transform(array $data): array
    {
        $addonServices = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $addonServiceData = $values[$i];
            if (!is_array($addonServiceData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $addonServices[] = $this->addonServiceTransformer->transform($addonServiceData);
        }

        return $addonServices;
    }
}
