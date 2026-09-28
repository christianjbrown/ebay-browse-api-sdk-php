<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardPictogram;
use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;

use function is_string;

final class HazardPictogramTransformer implements HazardPictogramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HazardPictogramInterface
    {
        $hazardPictogram = new HazardPictogram();

        self::applyPictogramDescription($hazardPictogram, $data);
        self::applyPictogramId($hazardPictogram, $data);
        self::applyPictogramUrl($hazardPictogram, $data);

        return $hazardPictogram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPictogramDescription(HazardPictogram $hazardPictogram, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAM_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_PICTOGRAM_DESCRIPTION])) {
            return;
        }
        $hazardPictogram->setPictogramDescription($data[self::KEY_PICTOGRAM_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPictogramId(HazardPictogram $hazardPictogram, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PICTOGRAM_ID])) {
            return;
        }
        $hazardPictogram->setPictogramId($data[self::KEY_PICTOGRAM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPictogramUrl(HazardPictogram $hazardPictogram, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAM_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_PICTOGRAM_URL])) {
            return;
        }
        $hazardPictogram->setPictogramUrl($data[self::KEY_PICTOGRAM_URL]);
    }
}
