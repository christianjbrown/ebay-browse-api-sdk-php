<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Exception;

use InvalidArgumentException;

final class MissingInputException extends InvalidArgumentException implements MissingInputExceptionInterface
{
}
