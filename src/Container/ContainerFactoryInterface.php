<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ContainerFactoryInterface
{
    public function create(): ContainerBuilder;
}
