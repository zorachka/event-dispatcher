<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\EventDispatcher\Infrastructure\PrioritizedListenerProvider;
use Zorachka\EventDispatcher\Infrastructure\SyncEventDispatcher;
use Zorachka\EventDispatcher\Infrastructure\ImmutablePrioritizedListenerProvider;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            ListenerProviderInterface::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $eventDispatcherConfig = $config['event-dispatcher'];
                $listeners = $eventDispatcherConfig['listeners'] ?? [];

                $providers = [];
                foreach ($listeners as $eventClassName => $eventListeners) {
                    $providers[] = new PrioritizedListenerProvider($eventClassName, $eventListeners);
                }

                return new ImmutablePrioritizedListenerProvider($providers);
            },
            EventDispatcherInterface::class => static function (ContainerInterface $container) {
                $listenerProvider = $container->get(ListenerProviderInterface::class);

                return new SyncEventDispatcher($listenerProvider);
            },
            'config' => $defaults['config'],
        ];
    }
}
