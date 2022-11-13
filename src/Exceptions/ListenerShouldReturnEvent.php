<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Exceptions;

use RuntimeException;

final class ListenerShouldReturnEvent extends RuntimeException
{
}
