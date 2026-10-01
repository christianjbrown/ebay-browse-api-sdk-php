<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CompanyAddressInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabelsInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelsInterface;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemComplianceTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemComplianceTransformer::class)]
final class ItemComplianceTransformerTest extends TestCase
{
    private ?CompanyAddressInterface $companyAddress = null;
    private ?ErrorInterface $error = null;
    private ?HazardousMaterialsLabelsInterface $hazardousMaterialsLabels = null;
    private ?ProductSafetyLabelsInterface $productSafetyLabels = null;
    private ?ResponsiblePersonInterface $responsiblePerson = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS => ['raw_hazardousMaterialsLabels'],
            ItemTransformerInterface::KEY_MANUFACTURER => ['raw_manufacturer'],
            ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS => ['raw_productSafetyLabels'],
            ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS => ['raw_responsiblePersons'],
            ItemTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame($this->hazardousMaterialsLabels, $actual->getHazardousMaterialsLabels());
        self::assertSame($this->companyAddress, $actual->getManufacturer());
        self::assertSame($this->productSafetyLabels, $actual->getProductSafetyLabels());
        self::assertSame([$this->responsiblePerson], $actual->getResponsiblePersons());
        self::assertSame([$this->error], $actual->getWarnings());
    }

    /**
     * @param array<string, mixed>         $data
     * @param Closure(ItemInterface): void $assert
     */
    #[DataProvider('provideApplyOptionalFieldStatesCases')]
    public function testApplyOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();
        $item = new Item('v_0');

        $transformer->apply($item, $data);

        $assert($item);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemInterface): void}>
     */
    public static function provideApplyOptionalFieldStatesCases(): iterable
    {
        $base = [ItemTransformerInterface::KEY_ITEM_ID => 'v_0'];

        yield 'allOptionalAbsent' => [
            [],
            static function (ItemInterface $model): void {
                self::assertNull($model->getHazardousMaterialsLabels());
                self::assertNull($model->getManufacturer());
                self::assertNull($model->getProductSafetyLabels());
                self::assertSame([], $model->getResponsiblePersons());
                self::assertSame([], $model->getWarnings());
            },
        ];

        yield 'hazardousMaterialsLabelsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getHazardousMaterialsLabels());
            },
        ];

        yield 'manufacturerWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MANUFACTURER => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getManufacturer());
            },
        ];

        yield 'productSafetyLabelsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getProductSafetyLabels());
            },
        ];

        yield 'responsiblePersonsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getResponsiblePersons());
            },
        ];

        yield 'warningsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_WARNINGS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getWarnings());
            },
        ];
    }

    private function buildTransformer(): ItemComplianceTransformer
    {
        $this->companyAddress = self::createStub(CompanyAddressInterface::class);
        $this->error = self::createStub(ErrorInterface::class);
        $this->hazardousMaterialsLabels = self::createStub(HazardousMaterialsLabelsInterface::class);
        $this->productSafetyLabels = self::createStub(ProductSafetyLabelsInterface::class);
        $this->responsiblePerson = self::createStub(ResponsiblePersonInterface::class);

        $companyAddressTransformer = self::createStub(CompanyAddressTransformerInterface::class);
        $companyAddressTransformer->method('transform')->willReturn($this->companyAddress);
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);
        $hazardousMaterialsLabelsTransformer = self::createStub(HazardousMaterialsLabelsTransformerInterface::class);
        $hazardousMaterialsLabelsTransformer->method('transform')->willReturn($this->hazardousMaterialsLabels);
        $productSafetyLabelsTransformer = self::createStub(ProductSafetyLabelsTransformerInterface::class);
        $productSafetyLabelsTransformer->method('transform')->willReturn($this->productSafetyLabels);
        $responsiblePersonsTransformer = self::createStub(ResponsiblePersonsTransformerInterface::class);
        $responsiblePersonsTransformer->method('transform')->willReturn([$this->responsiblePerson]);

        return new ItemComplianceTransformer($companyAddressTransformer, $errorsTransformer, $hazardousMaterialsLabelsTransformer, $productSafetyLabelsTransformer, $responsiblePersonsTransformer);
    }
}
