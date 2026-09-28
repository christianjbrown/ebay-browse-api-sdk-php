<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_walk;

final class ContainerFactory implements ContainerFactoryInterface
{
    /**
     * @var ServiceRegistrarInterface[]
     */
    private array $registrars;

    /**
     * @param ServiceRegistrarInterface[] $registrars Run in the given order, each registering
     *                                                its own service definitions on the same container
     */
    public function __construct(array $registrars)
    {
        $this->registrars = $registrars;
    }

    public function create(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        // array_walk over the registrar list keeps this a single, branch-free
        // path regardless of how many registrars are supplied, rather than a
        // for loop whose "loop not entered" state is a path a caller supplying
        // a fixed, non-empty registrar list can never reach.
        array_walk(
            $this->registrars,
            static function (ServiceRegistrarInterface $registrar) use ($container): void {
                $registrar->register($container);
            },
        );

        return $container;
    }
}
