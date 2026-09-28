<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabels;
use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;
use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HazardousMaterialsLabels::class)]
final class HazardousMaterialsLabelsTest extends TestCase
{
    public function test(): void
    {
        $pictograms = [self::createStub(HazardPictogramInterface::class)];
        $statements = [self::createStub(HazardStatementInterface::class)];

        $hazardousMaterialsLabels = new HazardousMaterialsLabels();
        self::assertNull($hazardousMaterialsLabels->getAdditionalInformation());
        self::assertSame([], $hazardousMaterialsLabels->getPictograms());
        self::assertNull($hazardousMaterialsLabels->getSignalWord());
        self::assertNull($hazardousMaterialsLabels->getSignalWordId());
        self::assertSame([], $hazardousMaterialsLabels->getStatements());

        self::assertSame($hazardousMaterialsLabels, $hazardousMaterialsLabels->setAdditionalInformation('val_additionalInformation'));
        self::assertSame($hazardousMaterialsLabels, $hazardousMaterialsLabels->setPictograms($pictograms));
        self::assertSame($hazardousMaterialsLabels, $hazardousMaterialsLabels->setSignalWord('val_signalWord'));
        self::assertSame($hazardousMaterialsLabels, $hazardousMaterialsLabels->setSignalWordId('val_signalWordId'));
        self::assertSame($hazardousMaterialsLabels, $hazardousMaterialsLabels->setStatements($statements));

        self::assertSame('val_additionalInformation', $hazardousMaterialsLabels->getAdditionalInformation());
        self::assertSame($pictograms, $hazardousMaterialsLabels->getPictograms());
        self::assertSame('val_signalWord', $hazardousMaterialsLabels->getSignalWord());
        self::assertSame('val_signalWordId', $hazardousMaterialsLabels->getSignalWordId());
        self::assertSame($statements, $hazardousMaterialsLabels->getStatements());
    }
}
