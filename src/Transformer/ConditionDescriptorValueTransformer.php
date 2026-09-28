<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValue;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;

use function is_array;
use function is_string;

final class ConditionDescriptorValueTransformer implements ConditionDescriptorValueTransformerInterface
{
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(StringsTransformerInterface $stringsTransformer)
    {
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConditionDescriptorValueInterface
    {
        $conditionDescriptorValue = new ConditionDescriptorValue();

        $this->applyAdditionalInfo($conditionDescriptorValue, $data);
        self::applyContent($conditionDescriptorValue, $data);

        return $conditionDescriptorValue;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdditionalInfo(ConditionDescriptorValue $conditionDescriptorValue, array $data): void
    {
        if (empty($data[self::KEY_ADDITIONAL_INFO])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_INFO])) {
            return;
        }
        $conditionDescriptorValue->setAdditionalInfo($this->stringsTransformer->transform($data[self::KEY_ADDITIONAL_INFO]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyContent(ConditionDescriptorValue $conditionDescriptorValue, array $data): void
    {
        if (empty($data[self::KEY_CONTENT])) {
            return;
        }
        if (!is_string($data[self::KEY_CONTENT])) {
            return;
        }
        $conditionDescriptorValue->setContent($data[self::KEY_CONTENT]);
    }
}
