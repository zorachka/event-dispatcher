<?php

declare(strict_types=1);

namespace Zorachka\Framework\EventDispatcher;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\Framework\Container\ServiceProvider;

final class EventDispatcherServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            ListenerProviderInterface::class => static function (ContainerInterface $container) {
                /** @var EventDispatcherConfig $config */
                $config = $container->get(EventDispatcherConfig::class);
                $listeners = $config->listeners();

                $providers = [];
                foreach ($listeners as $eventClassName => $rawEventListeners) {
                    $eventListeners = [];

                    foreach ($rawEventListeners as $eventListener) {
                        $eventListeners[] = $container->get($eventListener);
                    }
                    $providers[] = new PrioritizedListenerProvider($eventClassName, $eventListeners);
                }

                return new ImmutablePrioritizedListenerProvider($providers);
            },
            EventDispatcherInterface::class => static function (ContainerInterface $container) {
                $listenerProvider = $container->get(ListenerProviderInterface::class);

                return new SyncEventDispatcher($listenerProvider);
            },
            EventDispatcherConfig::class => fn() => EventDispatcherConfig::withDefaults(),
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [];
    }
}
