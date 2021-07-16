<?php

namespace Zorachka\EventDispatcher\Infrastructure;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    private ListenerRegistry $registry;

    public function __construct(ListenerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event): object
    {
        $listeners = $this->registry->listenersFor($event::class);

        foreach ($listeners as [$listener]) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }

            $listener($event);
        }

        return $event;
    }
}
