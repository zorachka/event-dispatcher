<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

final class EventDispatcherSpy implements EventDispatcher
{
    /**
     * @var array<object>
     */
    private array $dispatchedEvents = [];

    public function dispatch(object $event): void
    {
        $this->dispatchedEvents[] = $event;
    }

    /**
     * @return array<object>
     */
    public function dispatchedEvents(): array
    {
        /*
         * This method is not part of the `EventDispatcher` interface.
         * It's only here so we can later inspect the event objects that
         * have been passed to `dispatch()`.
         */

        return $this->dispatchedEvents;
    }

    public function dispatchAll(array $events): array
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }

        return $events;
    }
}
