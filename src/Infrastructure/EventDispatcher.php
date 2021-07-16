<?php

namespace Zorachka\EventDispatcher\Infrastructure;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use RuntimeException;

final class EventDispatcher implements EventDispatcherInterface
{
    private ListenerProviderInterface $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event): object
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $returnedEvent = $listener($event);

            if (! $returnedEvent instanceof $event) {
                throw new RuntimeException('The listener did not return what was expected: must return an event');
            }

            if ($returnedEvent instanceof StoppableEventInterface
                && $returnedEvent->isPropagationStopped()
            ) {
                break;
            }
        }

        return $event;
    }
}
