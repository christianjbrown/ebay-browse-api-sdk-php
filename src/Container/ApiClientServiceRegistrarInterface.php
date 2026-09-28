<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

/**
 * Registers the HTTP API clients, each of which references transformer and
 * credentials definitions registered by the other registrars. Must run last.
 */
interface ApiClientServiceRegistrarInterface extends ServiceRegistrarInterface
{
}
