<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ProductInterface
{
    /**
     * @return array<int, ImageInterface>
     */
    public function getAdditionalImages(): array;

    /**
     * @return array<int, AdditionalProductIdentityInterface>
     */
    public function getAdditionalProductIdentities(): array;

    /**
     * @return array<int, AspectGroupInterface>
     */
    public function getAspectGroups(): array;

    public function getBrand(): ?string;

    public function getDescription(): ?string;

    /**
     * @return array<int, string>
     */
    public function getGtins(): array;

    public function getImage(): ?ImageInterface;

    public function getMpn(): ?string;

    /**
     * @return array<int, string>
     */
    public function getMpns(): array;

    public function getTitle(): ?string;

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): self;

    /**
     * @param array<int, AdditionalProductIdentityInterface> $value
     */
    public function setAdditionalProductIdentities(array $value): self;

    /**
     * @param array<int, AspectGroupInterface> $value
     */
    public function setAspectGroups(array $value): self;

    public function setBrand(?string $value): self;

    public function setDescription(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setGtins(array $value): self;

    public function setImage(?ImageInterface $value): self;

    public function setMpn(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setMpns(array $value): self;

    public function setTitle(?string $value): self;
}
