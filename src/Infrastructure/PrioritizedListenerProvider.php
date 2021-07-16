<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Infrastructure;

use Psr\EventDispatcher\ListenerProviderInterface;
use Webmozart\Assert\Assert;

final class PrioritizedListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];
    private string $eventClassName;

    /**
     * PrioritizedListenerProvider constructor.
     * @param class-string $eventClassName
     * @param array $listeners
     */
    public function __construct(string $eventClassName, array $listeners)
    {
        Assert::allIsCallable($listeners);
        \krsort($listeners, \SORT_NUMERIC);

        foreach ($listeners as $listener) {
            $this->listeners[$eventClassName][] = $listener;
        }
        $this->eventClassName = $eventClassName;
    }

    /**
     * @return string
     */
    public function eventClassName(): string
    {
        return $this->eventClassName;
    }

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        $eventClassName = $event::class;
        if (isset($this->listeners[$eventClassName])) {
            return $this->listeners[$eventClassName];
        }

        return [];
    }
}
