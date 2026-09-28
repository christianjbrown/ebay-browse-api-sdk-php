<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void;
}
