<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

/**
 * Registers the transformers that have no nested transformer dependency of
 * their own. Must run before ComposedTransformerServiceRegistrarInterface.
 */
interface LeafTransformerServiceRegistrarInterface extends ServiceRegistrarInterface
{
}
