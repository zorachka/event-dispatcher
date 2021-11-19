<?php

declare(strict_types=1);

namespace Zorachka\Framework\EventDispatcher\Exceptions;

use RuntimeException;

final class ListenerShouldReturnEvent extends RuntimeException
{
}
