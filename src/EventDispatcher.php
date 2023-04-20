<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;

interface EventDispatcher extends EventDispatcherInterface
{
    public function dispatchAll(array $events): array;
}
