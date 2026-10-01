<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;

final class ItemComplianceTransformer implements ItemComplianceTransformerInterface
{
    private CompanyAddressTransformerInterface $companyAddressTransformer;
    private ErrorsTransformerInterface $errorsTransformer;
    private HazardousMaterialsLabelsTransformerInterface $hazardousMaterialsLabelsTransformer;
    private ProductSafetyLabelsTransformerInterface $productSafetyLabelsTransformer;
    private ResponsiblePersonsTransformerInterface $responsiblePersonsTransformer;

    public function __construct(CompanyAddressTransformerInterface $companyAddressTransformer, ErrorsTransformerInterface $errorsTransformer, HazardousMaterialsLabelsTransformerInterface $hazardousMaterialsLabelsTransformer, ProductSafetyLabelsTransformerInterface $productSafetyLabelsTransformer, ResponsiblePersonsTransformerInterface $responsiblePersonsTransformer)
    {
        $this->companyAddressTransformer = $companyAddressTransformer;
        $this->errorsTransformer = $errorsTransformer;
        $this->hazardousMaterialsLabelsTransformer = $hazardousMaterialsLabelsTransformer;
        $this->productSafetyLabelsTransformer = $productSafetyLabelsTransformer;
        $this->responsiblePersonsTransformer = $responsiblePersonsTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        $this->applyHazardousMaterialsLabels($item, $data);
        $this->applyManufacturer($item, $data);
        $this->applyProductSafetyLabels($item, $data);
        $this->applyResponsiblePersons($item, $data);
        $this->applyWarnings($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHazardousMaterialsLabels(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS])) {
            return;
        }
        $item->setHazardousMaterialsLabels($this->hazardousMaterialsLabelsTransformer->transform($data[ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyManufacturer(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_MANUFACTURER])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_MANUFACTURER])) {
            return;
        }
        $item->setManufacturer($this->companyAddressTransformer->transform($data[ItemTransformerInterface::KEY_MANUFACTURER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProductSafetyLabels(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS])) {
            return;
        }
        $item->setProductSafetyLabels($this->productSafetyLabelsTransformer->transform($data[ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyResponsiblePersons(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS])) {
            return;
        }
        $item->setResponsiblePersons($this->responsiblePersonsTransformer->transform($data[ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_WARNINGS])) {
            return;
        }
        $item->setWarnings($this->errorsTransformer->transform($data[ItemTransformerInterface::KEY_WARNINGS]));
    }
}
