<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Exception;

use RuntimeException;

final class ItemNotFoundException extends RuntimeException implements ItemNotFoundExceptionInterface
{
}
