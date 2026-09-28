<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AddonService;
use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;

use function is_array;
use function is_string;

final class AddonServiceTransformer implements AddonServiceTransformerInterface
{
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;

    public function __construct(ConvertedAmountTransformerInterface $convertedAmountTransformer)
    {
        $this->convertedAmountTransformer = $convertedAmountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AddonServiceInterface
    {
        $addonService = new AddonService();

        self::applySelection($addonService, $data);
        $this->applyServiceFee($addonService, $data);
        self::applyServiceId($addonService, $data);
        self::applyServiceType($addonService, $data);

        return $addonService;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySelection(AddonService $addonService, array $data): void
    {
        if (empty($data[self::KEY_SELECTION])) {
            return;
        }
        if (!is_string($data[self::KEY_SELECTION])) {
            return;
        }
        $addonService->setSelection($data[self::KEY_SELECTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyServiceFee(AddonService $addonService, array $data): void
    {
        if (empty($data[self::KEY_SERVICE_FEE])) {
            return;
        }
        if (!is_array($data[self::KEY_SERVICE_FEE])) {
            return;
        }
        $addonService->setServiceFee($this->convertedAmountTransformer->transform($data[self::KEY_SERVICE_FEE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyServiceId(AddonService $addonService, array $data): void
    {
        if (empty($data[self::KEY_SERVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SERVICE_ID])) {
            return;
        }
        $addonService->setServiceId($data[self::KEY_SERVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyServiceType(AddonService $addonService, array $data): void
    {
        if (empty($data[self::KEY_SERVICE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SERVICE_TYPE])) {
            return;
        }
        $addonService->setServiceType($data[self::KEY_SERVICE_TYPE]);
    }
}
