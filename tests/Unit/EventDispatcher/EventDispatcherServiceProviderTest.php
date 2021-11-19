<?php

declare(strict_types=1);

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\Framework\EventDispatcher\EventDispatcherConfig;
use Zorachka\Framework\EventDispatcher\EventDispatcherServiceProvider;

test('EventDispatcherServiceProvider should contain definitions', function () {
    expect(
        array_keys(EventDispatcherServiceProvider::getDefinitions())
    )->toMatchArray([
        ListenerProviderInterface::class,
        EventDispatcherInterface::class,
        EventDispatcherConfig::class,
    ]);
});
