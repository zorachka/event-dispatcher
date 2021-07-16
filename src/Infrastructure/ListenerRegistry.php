<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Infrastructure;

interface ListenerRegistry
{
    /**
     * @param class-string $eventClassName
     * @return array
     */
    public function listenersFor(string $eventClassName): array;
}
