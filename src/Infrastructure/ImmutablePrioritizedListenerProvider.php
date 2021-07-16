<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Infrastructure;

use Psr\EventDispatcher\ListenerProviderInterface;
use Webmozart\Assert\Assert;
use function usort;

final class ImmutablePrioritizedListenerProvider implements ListenerProviderInterface
{
    private array $providers = [];

    /**
     * ImmutablePrioritizedListenerProvider constructor.
     * @param PrioritizedListenerProvider[] $providers
     */
    public function __construct(array $providers)
    {
        Assert::allIsInstanceOf($providers, PrioritizedListenerProvider::class);
        foreach ($providers as $provider) {
            $this->providers[$provider->eventClassName()] = $provider;
        }
    }

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        $eventClassName = $event::class;
        if (isset($this->providers[$eventClassName])) {
            /** @var PrioritizedListenerProvider $provider */
            $provider = $this->providers[$eventClassName];
            return $provider->getListenersForEvent($event);
        }

        return [];
    }
}
