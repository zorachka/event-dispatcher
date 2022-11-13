<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

final class NullableEventListener
{
    public function __invoke(object $event): object
    {
        return $event;
    }
}
