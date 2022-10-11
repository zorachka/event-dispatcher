<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Exceptions;

use RuntimeException;

final class CouldNotFindListener extends RuntimeException
{
    public static function forEvent(
        object $event
    ): self {
        return new self(
            \sprintf('Could not find a listener for "%s" event', $event::class)
        );
    }
}
