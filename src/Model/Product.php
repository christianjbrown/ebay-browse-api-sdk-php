<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Product implements ProductInterface
{
    /**
     * @var array<int, ImageInterface>
     */
    private array $additionalImages = [];

    /**
     * @var array<int, AdditionalProductIdentityInterface>
     */
    private array $additionalProductIdentities = [];

    /**
     * @var array<int, AspectGroupInterface>
     */
    private array $aspectGroups = [];
    private ?string $brand = null;
    private ?string $description = null;

    /**
     * @var array<int, string>
     */
    private array $gtins = [];
    private ?ImageInterface $image = null;
    private ?string $mpn = null;

    /**
     * @var array<int, string>
     */
    private array $mpns = [];
    private ?string $title = null;

    /**
     * @return array<int, ImageInterface>
     */
    public function getAdditionalImages(): array
    {
        return $this->additionalImages;
    }

    /**
     * @return array<int, AdditionalProductIdentityInterface>
     */
    public function getAdditionalProductIdentities(): array
    {
        return $this->additionalProductIdentities;
    }

    /**
     * @return array<int, AspectGroupInterface>
     */
    public function getAspectGroups(): array
    {
        return $this->aspectGroups;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<int, string>
     */
    public function getGtins(): array
    {
        return $this->gtins;
    }

    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    public function getMpn(): ?string
    {
        return $this->mpn;
    }

    /**
     * @return array<int, string>
     */
    public function getMpns(): array
    {
        return $this->mpns;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): ProductInterface
    {
        $this->additionalImages = $value;

        return $this;
    }

    /**
     * @param array<int, AdditionalProductIdentityInterface> $value
     */
    public function setAdditionalProductIdentities(array $value): ProductInterface
    {
        $this->additionalProductIdentities = $value;

        return $this;
    }

    /**
     * @param array<int, AspectGroupInterface> $value
     */
    public function setAspectGroups(array $value): ProductInterface
    {
        $this->aspectGroups = $value;

        return $this;
    }

    public function setBrand(?string $value): ProductInterface
    {
        $this->brand = $value;

        return $this;
    }

    public function setDescription(?string $value): ProductInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setGtins(array $value): ProductInterface
    {
        $this->gtins = $value;

        return $this;
    }

    public function setImage(?ImageInterface $value): ProductInterface
    {
        $this->image = $value;

        return $this;
    }

    public function setMpn(?string $value): ProductInterface
    {
        $this->mpn = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setMpns(array $value): ProductInterface
    {
        $this->mpns = $value;

        return $this;
    }

    public function setTitle(?string $value): ProductInterface
    {
        $this->title = $value;

        return $this;
    }
}
