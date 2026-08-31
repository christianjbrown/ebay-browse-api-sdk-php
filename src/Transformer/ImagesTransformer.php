<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ImageInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ImagesTransformer implements ImagesTransformerInterface
{
    private ImageTransformerInterface $imageTransformer;

    public function __construct(ImageTransformerInterface $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ImageInterface>
     */
    public function transform(array $data): array
    {
        $images = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $imageData = $values[$i];
            if (!is_array($imageData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $images[] = $this->imageTransformer->transform($imageData);
        }

        return $images;
    }
}
