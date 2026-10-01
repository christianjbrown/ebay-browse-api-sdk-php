<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CompanyAddressInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabelsInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelsInterface;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemComplianceTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemComplianceTransformer::class)]
final class ItemComplianceTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $hazardousMaterialsLabelsTransformerModel = self::createStub(HazardousMaterialsLabelsInterface::class);
        $hazardousMaterialsLabelsTransformer = self::createStub(HazardousMaterialsLabelsTransformerInterface::class);
        $hazardousMaterialsLabelsTransformer->method('transform')->willReturn($hazardousMaterialsLabelsTransformerModel);
        $companyAddressTransformerModel = self::createStub(CompanyAddressInterface::class);
        $companyAddressTransformer = self::createStub(CompanyAddressTransformerInterface::class);
        $companyAddressTransformer->method('transform')->willReturn($companyAddressTransformerModel);
        $productSafetyLabelsTransformerModel = self::createStub(ProductSafetyLabelsInterface::class);
        $productSafetyLabelsTransformer = self::createStub(ProductSafetyLabelsTransformerInterface::class);
        $productSafetyLabelsTransformer->method('transform')->willReturn($productSafetyLabelsTransformerModel);
        $responsiblePersonsTransformerModel = self::createStub(ResponsiblePersonInterface::class);
        $responsiblePersonsTransformer = self::createStub(ResponsiblePersonsTransformerInterface::class);
        $responsiblePersonsTransformer->method('transform')->willReturn([$responsiblePersonsTransformerModel]);
        $errorsTransformerModel = self::createStub(ErrorInterface::class);
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$errorsTransformerModel]);
        $data = [
            ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS => ['raw_HazardousMaterialsLabels'],
            ItemTransformerInterface::KEY_MANUFACTURER => ['raw_Manufacturer'],
            ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS => ['raw_ProductSafetyLabels'],
            ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS => ['raw_ResponsiblePersons'],
            ItemTransformerInterface::KEY_WARNINGS => ['raw_Warnings'],
        ];
        $item = new Item('v_0');

        $transformer = new ItemComplianceTransformer($companyAddressTransformer, $errorsTransformer, $hazardousMaterialsLabelsTransformer, $productSafetyLabelsTransformer, $responsiblePersonsTransformer);
        $transformer->apply($item, $data);

        self::assertSame($hazardousMaterialsLabelsTransformerModel, $item->getHazardousMaterialsLabels());
        self::assertSame($companyAddressTransformerModel, $item->getManufacturer());
        self::assertSame($productSafetyLabelsTransformerModel, $item->getProductSafetyLabels());
        self::assertSame([$responsiblePersonsTransformerModel], $item->getResponsiblePersons());
        self::assertSame([$errorsTransformerModel], $item->getWarnings());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemComplianceTransformer(self::createStub(CompanyAddressTransformerInterface::class), self::createStub(ErrorsTransformerInterface::class), self::createStub(HazardousMaterialsLabelsTransformerInterface::class), self::createStub(ProductSafetyLabelsTransformerInterface::class), self::createStub(ResponsiblePersonsTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}
