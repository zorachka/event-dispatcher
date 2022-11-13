<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Exceptions;

use RuntimeException;

final class ListenerShouldReturnEvent extends RuntimeException
{
    public static function for(
        string $listenerClassName,
        string $eventClassName
    ): self {
        return new self(
            \sprintf(
                'The "%s" listener did not return what was expected: must return an "%s" event',
                $listenerClassName,
                $eventClassName,
            )
        );
    }
}
