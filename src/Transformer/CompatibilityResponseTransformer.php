<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CompatibilityResponse;
use ChristianBrown\EBay\Browse\Model\CompatibilityResponseInterface;

use function is_array;
use function is_string;

final class CompatibilityResponseTransformer implements CompatibilityResponseTransformerInterface
{
    private ErrorsTransformerInterface $errorsTransformer;

    public function __construct(ErrorsTransformerInterface $errorsTransformer)
    {
        $this->errorsTransformer = $errorsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CompatibilityResponseInterface
    {
        $compatibilityResponse = new CompatibilityResponse();

        self::applyCompatibilityStatus($compatibilityResponse, $data);
        $this->applyWarnings($compatibilityResponse, $data);

        return $compatibilityResponse;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCompatibilityStatus(CompatibilityResponse $compatibilityResponse, array $data): void
    {
        if (empty($data[self::KEY_COMPATIBILITY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPATIBILITY_STATUS])) {
            return;
        }
        $compatibilityResponse->setCompatibilityStatus($data[self::KEY_COMPATIBILITY_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(CompatibilityResponse $compatibilityResponse, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $compatibilityResponse->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
