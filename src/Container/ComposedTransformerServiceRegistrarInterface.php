<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

/**
 * Registers the transformers that are built by composing one or more leaf or
 * other composed transformers. Must run after
 * LeafTransformerServiceRegistrarInterface and before
 * ApiClientServiceRegistrarInterface.
 */
interface ComposedTransformerServiceRegistrarInterface extends ServiceRegistrarInterface
{
}
