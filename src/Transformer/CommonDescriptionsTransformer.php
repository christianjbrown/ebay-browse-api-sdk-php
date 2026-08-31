<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CommonDescriptionsTransformer implements CommonDescriptionsTransformerInterface
{
    private CommonDescriptionTransformerInterface $commonDescriptionTransformer;

    public function __construct(CommonDescriptionTransformerInterface $commonDescriptionTransformer)
    {
        $this->commonDescriptionTransformer = $commonDescriptionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CommonDescriptionInterface>
     */
    public function transform(array $data): array
    {
        $commonDescriptions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $commonDescriptionData = $values[$i];
            if (!is_array($commonDescriptionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $commonDescriptions[] = $this->commonDescriptionTransformer->transform($commonDescriptionData);
        }

        return $commonDescriptions;
    }
}
