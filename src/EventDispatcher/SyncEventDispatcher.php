<?php

namespace Zorachka\Framework\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Zorachka\Framework\EventDispatcher\Exceptions\CouldNotFindListener;
use Zorachka\Framework\EventDispatcher\Exceptions\ListenerShouldReturnEvent;

final class SyncEventDispatcher implements EventDispatcherInterface
{
    private ListenerProviderInterface $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @inheritDoc
     * @throws CouldNotFindListener
     */
    public function dispatch(object $event): object
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $returnedEvent = $listener($event);

            if (! $returnedEvent instanceof $event) {
                throw new ListenerShouldReturnEvent(
                    \sprintf(
                        'The "%s" listener did not return what was expected: must return an "%s" event',
                        $listener::class,
                        $event::class,
                    )
                );
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
