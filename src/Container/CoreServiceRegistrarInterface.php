<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

/**
 * Registers the OAuth2 machinery and credentials that every API client and
 * every transformer depends on, directly or indirectly. Must run before any
 * other registrar.
 */
interface CoreServiceRegistrarInterface extends ServiceRegistrarInterface
{
}
