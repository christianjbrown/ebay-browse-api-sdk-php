<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Image;
use ChristianBrown\EBay\Browse\Model\ImageInterface;

use function is_int;
use function is_string;
use function sprintf;

final class ImageTransformer implements ImageTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ImageInterface
    {
        if (empty($data[self::KEY_IMAGE_URL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_IMAGE_URL));
        }
        if (!is_string($data[self::KEY_IMAGE_URL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_IMAGE_URL));
        }
        $image = new Image($data[self::KEY_IMAGE_URL]);

        self::applyHeight($image, $data);
        self::applyWidth($image, $data);

        return $image;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHeight(Image $image, array $data): void
    {
        if (!isset($data[self::KEY_HEIGHT])) {
            return;
        }
        if (!is_int($data[self::KEY_HEIGHT])) {
            return;
        }
        $image->setHeight($data[self::KEY_HEIGHT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWidth(Image $image, array $data): void
    {
        if (!isset($data[self::KEY_WIDTH])) {
            return;
        }
        if (!is_int($data[self::KEY_WIDTH])) {
            return;
        }
        $image->setWidth($data[self::KEY_WIDTH]);
    }
}
