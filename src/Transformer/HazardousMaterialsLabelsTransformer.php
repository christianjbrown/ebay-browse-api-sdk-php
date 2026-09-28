<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabels;
use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabelsInterface;

use function is_array;
use function is_string;

final class HazardousMaterialsLabelsTransformer implements HazardousMaterialsLabelsTransformerInterface
{
    private HazardPictogramsTransformerInterface $hazardPictogramsTransformer;
    private HazardStatementsTransformerInterface $hazardStatementsTransformer;

    public function __construct(HazardPictogramsTransformerInterface $hazardPictogramsTransformer, HazardStatementsTransformerInterface $hazardStatementsTransformer)
    {
        $this->hazardPictogramsTransformer = $hazardPictogramsTransformer;
        $this->hazardStatementsTransformer = $hazardStatementsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HazardousMaterialsLabelsInterface
    {
        $hazardousMaterialsLabels = new HazardousMaterialsLabels();

        self::applyAdditionalInformation($hazardousMaterialsLabels, $data);
        $this->applyPictograms($hazardousMaterialsLabels, $data);
        self::applySignalWord($hazardousMaterialsLabels, $data);
        self::applySignalWordId($hazardousMaterialsLabels, $data);
        $this->applyStatements($hazardousMaterialsLabels, $data);

        return $hazardousMaterialsLabels;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdditionalInformation(HazardousMaterialsLabels $hazardousMaterialsLabels, array $data): void
    {
        if (empty($data[self::KEY_ADDITIONAL_INFORMATION])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDITIONAL_INFORMATION])) {
            return;
        }
        $hazardousMaterialsLabels->setAdditionalInformation($data[self::KEY_ADDITIONAL_INFORMATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPictograms(HazardousMaterialsLabels $hazardousMaterialsLabels, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAMS])) {
            return;
        }
        if (!is_array($data[self::KEY_PICTOGRAMS])) {
            return;
        }
        $hazardousMaterialsLabels->setPictograms($this->hazardPictogramsTransformer->transform($data[self::KEY_PICTOGRAMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySignalWord(HazardousMaterialsLabels $hazardousMaterialsLabels, array $data): void
    {
        if (empty($data[self::KEY_SIGNAL_WORD])) {
            return;
        }
        if (!is_string($data[self::KEY_SIGNAL_WORD])) {
            return;
        }
        $hazardousMaterialsLabels->setSignalWord($data[self::KEY_SIGNAL_WORD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySignalWordId(HazardousMaterialsLabels $hazardousMaterialsLabels, array $data): void
    {
        if (empty($data[self::KEY_SIGNAL_WORD_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SIGNAL_WORD_ID])) {
            return;
        }
        $hazardousMaterialsLabels->setSignalWordId($data[self::KEY_SIGNAL_WORD_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStatements(HazardousMaterialsLabels $hazardousMaterialsLabels, array $data): void
    {
        if (empty($data[self::KEY_STATEMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_STATEMENTS])) {
            return;
        }
        $hazardousMaterialsLabels->setStatements($this->hazardStatementsTransformer->transform($data[self::KEY_STATEMENTS]));
    }
}
