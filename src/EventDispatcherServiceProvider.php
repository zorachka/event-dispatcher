<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\Container\ServiceProvider;

final class EventDispatcherServiceProvider implements ServiceProvider
{
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
                    $providers[] = new PrioritizedListenerProvider(
                        eventClassName: $eventClassName,
                        listeners: $eventListeners
                    );
                }

                return new ImmutablePrioritizedListenerProvider($providers);
            },
            EventDispatcher::class => static function (ContainerInterface $container) {
                /** @var ListenerProviderInterface $listenerProvider */
                $listenerProvider = $container->get(ListenerProviderInterface::class);

                return new SyncEventDispatcher($listenerProvider);
            },
            EventDispatcherInterface::class => static function (ContainerInterface $container) {
                /** @var ListenerProviderInterface $listenerProvider */
                $listenerProvider = $container->get(ListenerProviderInterface::class);

                return new SyncEventDispatcher($listenerProvider);
            },
            EventDispatcherConfig::class => static fn () => EventDispatcherConfig::withDefaults(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
